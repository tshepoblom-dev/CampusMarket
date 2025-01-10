<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class PurchaseVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if(alreadyInstalled()){
            if (Config::get('app.app_verify')==true) {
                return $next($request);
            }

        if(Auth::check()){
            if(auth()->user()->role == 4){
                return  redirect()->route('license.verify')->with('error', 'Your Purchase Code not verify.') ;
            }else{
                return  abort(403, 'Your Purchase Code not verify.') ;
            }
        }
         return  abort(403, 'Your Purchase Code not verify.') ;
        }
        return $next($request);

    }
}
