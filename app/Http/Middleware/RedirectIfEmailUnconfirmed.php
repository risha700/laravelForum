<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class RedirectIfEmailUnconfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(! $request->user()->confirmed){

            return redirect('/threads')->with('flash', 'Pending memebership confirmation');
        }

        return $next($request);
    }
}
