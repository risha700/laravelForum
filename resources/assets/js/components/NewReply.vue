<template>
			<div>
            <div class="" style="margin-top:2em;" v-if="signedIn">

                    <!--<textarea-->
                    <!--v-model="body"-->
                    <!--rows="5"-->
                    <!--id="body"-->
                    <!--class="form-control"-->
                    <!--placeholder="wanna say somethin'!!"-->
                    <!--required>-->
                	<!--</textarea>-->
                <wysiwyg name="body" v-model="body" placeholder="wanna say somethin'!!" ref="trix"></wysiwyg>
                <div class="form-group">
                    <button class="btn btn-default" @click="addReply">Post a Comment</button>
                </div>
                </div>


            <p class="text-center" v-else>Please <a href="/login">Sign in</a> to participate</p>



                </div>

            </div>




</template>


<script>


import 'at.js';
import 'jquery.caret';


	export default{
		props:['endpoint'],

		data(){
			return{
				body:''
			};
		},
		computed:{

				signedIn(){
					return window.App.signedIn;
				}


		},
		mounted(){

			$('[input="trix"]').atwho({

					at:'@',
					delay:750,
					callbacks:{

						remoteFilter: function (query, calback){
							console.log('called');

								$.getJSON("/api/users", {q:query}, function(usernames){

										calback(usernames)

								});
						}

					}

			});
	},
		methods:{

				addReply(){

					axios.post(this.endpoint,{body: this.body})

						.catch(error=>{

							flash(error.response.data, 'danger');
							// console.log(error.response.data);
							// return false;
						})

						.then(({data})=>{

							this.body='';
                            this.$refs.trix.$refs.trix.value='';
							flash('your reply added');

							this.$emit('created', data);


						});
						// .then(response=>{

						// 	this.body='';

						// 	flash('your reply added');

						// 	this.$emit('created', response.data);


						// });

				}



		}



	}



</script>