<template>

    <div class="alert alert-dismissible fade show" :class="'alert-'+level" id="message" role="alert" 
    v-show="show">
      <strong> {{body}}</strong>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

</template>

<script>
    export default {


        props:['message'],

        data(){
            return{
            
            body:this.message,
            level:'success',

            show:false
            }
        },
        created(){

            if (this.message) {

               this.flash();

            }


           window.events.$on(
            'flash', data =>
                this.flash(data)

            );


        },

        methods:{

            flash(data){

                if(data){

                this.body=data.message;
                this.level = data.level; 
                }


                this.show=true;

                this.hide();
              
            },

            hide(){

               setTimeout(()=>{
                   this.show=false; 
                },3000);
            },


        }




    }



</script>
