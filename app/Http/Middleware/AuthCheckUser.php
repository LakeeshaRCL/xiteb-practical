<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthCheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        Log::warning('Current path : '.$request->path());
        Log::info("LoggedUser : ".session()->has("loggedUser"));
 
        if(!session()->has("loggedUser") && ($request->path() != 'userAuth/login' && $request->path() != 'userAuth/register')){
            return redirect('/userAuth/login')->with("feedbackMsg","You must be logged in");
        }

        if(session()->has("loggedUser") && ($request->path() == 'userAuth/login' || $request->path() == 'userAuth/register')){
            return back();
        }
        return $next($request)  ->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
                                ->header('Pragma','no-cache')
                                ->header('expires', 'Sat 01 Jan 1990 00:00:00 GMT');
    }
}
