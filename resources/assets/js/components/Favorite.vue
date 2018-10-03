<template>


<div class=" float-right">
<button :class="classes" @click="toggle">

	<!-- <span class="glyphicon glyphicon-heart"></span> -->
	<i class="fa fa-thumbs-up"></i>
	 <span class="badge badge-light" v-text="count"></span>


</button>




</div>

</template>


<script>
export default{
		props:['model'],
		
		data(){

			return{

				count: this.model.favorites_count,
				isFavorited: this.model.is_favorited
			}

		},
		computed:{

			classes(){
				return ['btn', this.isFavorited ? 'btn-danger' : 'btn-default'];
			},
			endpoint(){
				// return '/replies/' + this.model.id + '/favorites';
				return [ this.model.hasOwnProperty('best_reply_id') ? '/threads/' + this.model.slug + '/favorites'
					: '/replies/' + this.model.id + '/favorites'];
			}

		},
		methods:{

			toggle(){
				 this.isFavorited ? this.destroy() : this.create();
				// if(this.isFavorited){
				// 	this.destroy();

				// 	// axios.delete('/replies/'+ this.reply.id + '/favorites');
				// 	// this.isFavorited = false;
				// 	// this.count--;
				// }else{

				// 	this.create();

				// 	// axios.post('/replies/' + this.reply.id + '/favorites');
				// 	// this.isFavorited = true;
				// 	// this.count++;
				// }
			},

			create(){

				axios.post(this.endpoint);
				this.isFavorited = true;
				this.count++;
				window.flash('liked');

			},

			destroy(){

				axios.delete(this.endpoint);
				this.isFavorited = false;
				this.count--;
                window.flash('Unliked', 'warning');
			}




		}




}



</script>