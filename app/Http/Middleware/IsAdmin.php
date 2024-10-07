<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if (Auth::user() &&  Auth::user()->user_type_id == 1) {
            if (auth()->user()->can('read_dashboard')) {
                return $next($request);
            } else {
                return redirect()->route('staffHome');
            }
        } else if (Auth::user() &&  Auth::user()->user_type_id == 2) {
            if (auth()->user()->can('read_dashboard')) {
                return redirect()->route('staffHome');
            } else {
                return redirect()->route('staffHome');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
