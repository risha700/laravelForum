<template>

	<div>
		<div v-for="(reply, index) in items" :key="reply.id">

			<reply :data="reply" @deleted="remove(index)"></reply>
		</div>
			  <paginator :dataSet="dataSet" @pageUpdated="fetch"></paginator>
				<div class="title text-center" v-if="$parent.locked" >
					<span class="lead">this topic is currently locked and replies not allowed</span>
				</div>
              <new-reply :endpoint="endpoint" @created="add" v-else></new-reply>
            
	</div>

</template>


<script>
	import Reply from './Reply.vue';
	import NewReply from './NewReply.vue';
	import Collection from './mixins/Collection.js';



	export default{

		// props:['data'],

		components:{Reply, NewReply},
		mixins:[Collection],

		data(){

			return{

				// items:this.data,
				dataSet:false,
				// items:[],
				endpoint: location.pathname +'/replies'
			} 

		},
		created(){

			this.fetch();



		},
		methods:{
			fetch(page){

				axios.get(this.url(page))
				.then(this.refresh);



			},
			url(page){

				if(! page){

					let query=location.search.match(/page=(\d+)/);

					page = query ? query[1] : 1;
				}

				return location.pathname +'/replies?page='+ page;


			},
			refresh({data}){

				this.dataSet= data;
				this.items=data.data;
				window.scroll(0, 0);

			},
			// moved to mixins
			// add(reply){

			// 	this.items.push(reply);

			// 	this.$emit('added');
			// },
			// remove(index){

			// 	this.items.splice(index, 1);
			// 	this.$emit('removed');
			// 	flash('reply deleted');
			// }
		}


	}


</script>