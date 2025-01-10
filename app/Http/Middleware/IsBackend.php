<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class IsBackend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() &&  Auth::user()->role == 3 || Auth::check() &&  Auth::user()->role == 4) {
            return $next($request);
        }elseif(Auth::check() &&  Auth::user()->role == 2 && Auth::user()->email_verified_at != null){
            return $next($request);
        }elseif(Auth::check() &&  Auth::user()->role == 2 && Auth::user()->email_verified_at == null){
            return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : Redirect::guest(URL::route('verification.notice'));
        }
        return redirect()->back()->with('error','You have not backend access');
    }
}
