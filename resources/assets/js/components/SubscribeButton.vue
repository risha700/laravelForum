<template>
	<div class="d-flex p-2" v-if="canUpdate">
		<button :class="classes" @click.prevent="subscribe" v-text="status"></button>
	</div>

</template>

<script>

	export default{

			props:['state'],

			data(){

					return{

						stateInfo:this.state
					};
				},
			computed:{

				classes(){
					return ['btn', this.stateInfo ? 'btn-success' : 'btn-outline-success'];
				},
				status(){
					return this.stateInfo ? 'unsubscribe' : 'subscribe';
				},
                canUpdate(){

                    return this.authorize(user=> user.id == window.App.user.id);

                }

			},



			methods:{

				subscribe(){
					let requestType = this.stateInfo ? 'delete' : 'post';
					axios[requestType](location.pathname +'/subscription');

					let subscriptionMessage = this.stateInfo ? 'unsubscribed' : 'subscribed';
					flash(subscriptionMessage);

					this.stateInfo = !this.stateInfo;
		
				}

			}




	}

</script>