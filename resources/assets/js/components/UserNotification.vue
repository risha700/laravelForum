<template>

		<div class="dropdown" v-if="notifications.length">
		  <button class="btn fa fa-bell" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  
		  </button>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="left:-167px;">
			  <div v-for="notification in notifications"  class="dropdown-item">
			    <a :href="notification.data.link">

				  	<span 
				  	v-text="notification.data.message" 
				  	@click="markAsRead(notification)">

					
	
				     </span>
				</a>
				<small class="float-right d-inline-flex">{{createdAt}}</small>
					     
		     </div>
		  </div>
		</div>
</template>



<script>
import moment from 'moment';
	export default{
		props:['time'],
		data(){

			return{
				notifications:false
			}
		},

		created(){


			axios.get('/profile/' + window.App.user.name +'/notifications' )

			.then(response=>this.notifications = response.data);
		},
		methods:{
			markAsRead(notification){

				axios.delete('profile/'+ window.App.user.name + '/notifications/'+ notification.id);
			}
		},
		computed:{

			createdAt(notification){

				return moment(notification.created_at).fromNow();
			}
		}


	}
</script>