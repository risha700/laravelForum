
<template>


<div>

    <div>
         
     <div :id="'reply-'+id " class="card">
      <div class="card-header"><a :href="'/profile/'+data.user.name" v-text="data.user.name"> 
      	</a> said... <span class="" v-text="ago"></span>


        <favorite :model="data" v-if="signedIn"></favorite>




      </div>
          <div class="card-body">
           
            <div v-if="editing" >
              <!--<textarea class="form-control" v-model="body" required></textarea>-->
                <wysiwyg class="form-control" v-model="body"></wysiwyg>

              <button class="btn" @click="update">
                <i class="fa fa-check-circle" style="color:#28a745;font-size:2em;"></i>
            </button>

              <button class="btn btn-link-warning" @click="cancel">
                <i class="fa fa-times" style="color:#dc3545;font-size:2em;"></i>
            </button>

            </div>
            <div v-else v-html="body">

                

            </div>
              </div>


               <div class="d-inline-flex p-2 flex-md-row-reverse" >
               	<div>
               	<button class="btn d-flex" @click="markBestReply" v-if="threadOwner || isAdmin">
               		<i class="fa fa-star" :class="isBest? 'text-warning':'' "></i>
               	</button>
               	</div>
                 <button class="btn d-flex" @click="editing=true" v-if="canUpdate || isAdmin">
                  <i class="fa fa-edit" style="color:#007bff;font-size:1.7em;"></i></button>

                 <button class="btn d-flex" @click="destroy" v-if="canUpdate || isAdmin">
                  <i class="fa fa-trash" style="color:#dc3545;font-size:1.7em;"></i></button>

            </div>
          </div>
        </div>
	

	</div>



</template>
<script>

import Favorite from './Favorite.vue';

import moment from 'moment';



export default{
	props:['data'],

	components:{Favorite},

	data(){
		return{
			editing:false,
			id:this.data.id,
			body: this.data.body,
			isBest:this.data.is_best,
			reply:this.data,
            // thread:this.data.user_id
            threadOwner: this.data.thread_owner,
            isAdmin:this.data.user.is_admin
		};
	},
	computed:{

			signedIn(){

				return window.App.signedIn;
			},
			canUpdate(){

				return this.authorize(user=> this.data.user_id == window.App.user.id)

				// return this.data.user_id == window.App.user.id;
			},
			ago(){

				return moment(this.data.created_at).fromNow();
			}

	},
	created(){

		window.events.$on('best-reply-selected', id =>{

			this.isBest = (id === this.data.id);
		});

	},
	methods: {
	    cancel(){


            this.body=this.reply.body;

            this.editing=false;

        },

		update(){
			axios.patch("/replies/" + this.data.id, {
				body: this.body
			})
			.catch( error => {
				console.log(error.response);
				flash(error.response.data, 'danger');
				return false;
			})

			

				this.editing=false;
				flash('updated successfully');

			
		},
		destroy(){
			axios.delete("/replies/" + this.data.id);

				this.$emit('deleted',this.data.id);

			// old school way
			// $(this.$el).fadeOut(1000);
			// flash('Reply deleted');
	},
		markBestReply(){


			this.isBest = true;
			axios.post('/replies/'+this.data.id+'/best')
			.catch( error => {
				console.log(error.response);
				flash(error.response.data, 'danger');
			})

			flash('Marked as BEST');
			window.events.$emit('best-reply-selected', this.data.id);


		}


}

}








</script>