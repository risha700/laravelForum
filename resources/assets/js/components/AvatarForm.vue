<template>

	<div class="container">
		<div class="d-flex align-items-end">
	   <img  :src="avatar" with="100" height="70" >
		<h1 v-text="user.name"></h1>
		</div>

        <form v-if="canUpdate" method="POST"  enctype="multipart/form-data">

          <!-- <input type="file" name="avatar" accept="image/*" @change="onChange" id="avatar"> -->

          <image-upload name="avatar" @loaded="onLoad"></image-upload>

        </form>

   




	</div>

</template>

<script>
import ImageUpload from './ImageUpload.vue';

	export default {

		props:['user'],
		components:{ImageUpload},
		computed:{

			canUpdate(){

				return this.authorize(user=> user.id === this.user.id);
			}
		},
		data(){
			return{

				avatar: this.user.avatar_path
			}
		},


		methods:{
			onLoad(data){
			
				// if(! e.target.files.length) return;


				// let file = e.target.files[0];


				// let reader = new FileReader();

				// reader.readAsDataURL(file);

				// reader.onload = e =>{
				// 		// console.log(e);
				// 	this.avatar = e.target.result;
				// };

				this.avatar = data.src;

				this.presist(data.file);


			},

			presist(file){

				let data = new FormData();
				data.append('avatar', file);

				// axios.post(`/api/users/{this.user.name}/avatar`, data)
				// .then(()=>window.flash('Uploaded'));	

				axios.post('/api/users/'+this.user.name+'/avatar', data)
				.then(({file})=>{
					window.flash('Avatar uploaded')
					});
			}
		}

	}


</script>