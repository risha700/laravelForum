<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;


class RegisterConfirmationController extends Controller
{
    public function index()
    {
    	try{
    	
    	User::where('confirmation_token', request('token'))
    	->firstOrFail()
    	->confirmed();
    	// ->update(['confirmed'=>true]);
		}catch(\Exception $e){

		return redirect('/threads')->with('flash', 'Unknown token');

		}
    	return redirect('/threads')->with('flash', 'Your account is now activated');

    }



}
