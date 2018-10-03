<?php

namespace App\Inspections;



use Exception;

class InvalidKeyWords
{


	protected $keywords =[
    				'fuck',
    				'shit'
	];

	public function detect($body)
	{

    	foreach ($this->keywords as $keyword) {
    		
    	if(stripos($body, $keyword) !==false){

        throw new Exception("be nice dude");
        
	       }

    	}



	}




}