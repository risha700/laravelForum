<?php

namespace App;

trait RecordsActivity

{

    protected static function bootRecordsActivity(){


        if (auth()->guest()) return;

        foreach(static::getRecordEvents() as $event){


         static::$event(function($model) use ($event){

                $model->recordActivity($event);

          });
         }



        static::deleted(function($model){

            $model->activity()->delete();

        });




    }




    protected static function getRecordEvents(){

      return['created'];
    }









    protected function recordActivity($event){

              $this->activity()->create([


                'user_id'=>auth()->id(),
                'subject_id'=> $this->id,
                'subject_type'=>get_class($this),
                'type'=>$this->getActivityType($event)
          


            ]);

            // Activity::create([

            //     'user_id'=>auth()->id(),
            //     'type'=>$this->getActivityType($event),
            //     'subject_id'=> $this->id,
            //     'subject_type'=>get_class($this)
            //     ]);

            
        }

        public function activity(){

          return $this->morphMany('\App\Activity', 'subject');
        }

        protected function getActivityType($event)


        {

            $type = strtolower( (new \ReflectionClass($this))->getShortName() ) ;
            return "{$event}_{$type} ";
        }




}