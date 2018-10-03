<?php

namespace App\Inspections;

// use Illuminate\Database\Eloquent\Model;

class Spam 
{


    protected $inspections = [

        InvalidKeyWords::class,
        KeyHeldDown::class

    ];


    public function detect($body)
    {


        foreach($this->inspections as $inspection) {
           
            app($inspection)->detect($body);

        }
// this is the old way before we graduate spam class

    	// $this->detectInvalidKeyWords($body);
    	// $this->detectKeyHeldDown($body);

    	return false;
    }


    // public function detectInvalidKeyWords($body)
    // {
    	// $InvalidKeyWords = [

    	// 			'fuck',
    	// 			'shit'

    	// ];


    	// foreach ($InvalidKeyWords as $keyword) {
    		
    	// if(stripos($body, $keyword) !==false){

     //    throw new \Exception("be nice dude");
        
	    //    }

    	// }

    // }


//     public function detectKeyHeldDown($body)
//     {
//     	if(preg_match('/(.)\\1{4,}/', $body)){

// 			throw new \Exception("tell a meaningful statement");

//     	}
//     }


}
