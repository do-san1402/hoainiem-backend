<?php

namespace App\Http\Middleware;

use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('demo.demo_mode')) {
            if($request->ajax()){
                return response()->json([
                    'success' => true,
                    'message' => localize("this_action_is_not_allow_on_the_demo_site"),
                    'title'   => localize("demo_mode"),
                ], 405);
            }

            toastr()->error('This action is not allowed on the demo site.');
            return redirect()->back();
        }

        return $next($request);
    }
}
