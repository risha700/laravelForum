<script>

	import Replies from './Replies.vue';
	import SubscribeButton from './SubscribeButton.vue';

	export default{
		props:['thread'],
		components:{Replies, SubscribeButton},

		data(){

			return{
				repliesCount:this.thread.reply_count,
                locked:this.thread.locked,
               isAdmin:this.thread.user.is_admin,
                editing:false,
                form:{
				    title:this.thread.title,
                    body:this.thread.body
                },
			};
		},
        computed:{

            signedIn(){

                return window.App.signedIn;
            },
            classes(){
                return [this.locked ? 'fa fa-unlock text-success' : 'fa fa-lock text-danger'];
            }
        },
        methods: {

		    toggleLock(){



		        // axios.patch('/threads/'+ this.thread.channel.slug + '/' + this.thread.slug);
		        axios[ this.locked ? 'delete' : 'patch']
                ('/lock/'+ this.thread.channel.slug + '/' + this.thread.slug)
                    .then(()=>{
                    window.flash( this.locked ? 'Unlocked' : 'Locked', 'warning');
                this.locked = ! this.locked;
            })
                    .catch( error => {
                    console.log(error);
                flash('Unauthorized', 'danger');
            });

            },
            cancel(){

                this.form={
                    title:this.thread.title,
                    body:this.thread.body
                };
                this.editing=false;

            },

            update(){

		        axios.patch('/threads/'+ this.thread.channel.slug+'/'+this.thread.slug,{
		           title:this.form.title,
                   body:this.form.body

                })
                    .then(()=>{
                        this.editing=false;
                        flash('Updated');
                })
            .catch(e=>{
                    console.log(e.response.data);
                flash(e.response.data.errors, 'danger');
                });


            }
        }




	}




</script>