<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleComments
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'comments.' . $request->user()->id;

        if ($this->limiter->tooManyAttempts($key, 5)) { // 5 komentar per menit
            return response()->json([
                'message' => 'Terlalu banyak komentar. Silakan tunggu beberapa saat.'
            ], 429);
        }

        $this->limiter->hit($key, 60); // Reset setelah 60 detik

        return $next($request);
    }
} 