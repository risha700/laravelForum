<?php

namespace App\Providers;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // this is one way


        \View::composer('*', function($view){

            $channels = \Cache::rememberForever('channels', function(){
                return \App\Channel::all();

            });

            
                $view->with('channels', $channels );
        });


        // yet another way to share




         \View::share('thread', \App\Thread::all());





        //  Builder::macro('reorder', function() {
        //     $property = $this->unions ? 'unionOrders' : 'orders';

        //     $this->{$property} = null;

        //     if (func_num_args() > 0) {
        //         return $this->orderBy(...func_get_args());
        //     }

        //     return $this;
        // });

        // INTEGRATE VALIDATION
         // \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
