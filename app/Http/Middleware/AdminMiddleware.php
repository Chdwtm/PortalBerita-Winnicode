<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->role !== 'admin') {
        return redirect()->route('home'); // Arahkan user non-admin ke home
    }
    return $next($request);
}

}