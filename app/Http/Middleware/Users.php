<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Users
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('status')==0) {
            return redirect('login');
           }
        // dd($request->session()->get('status'));
        if (!$request->session()->get('level')) {
            if ($request->session()->get('level')==4) {
               
                return redirect('login');
            }
          
        }
        return $next($request);
    }
}
