<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        if (!session()->has('level')) {
            abort(403);
        }
        if (!in_array((string) session('level'), $levels)) {
            abort(403);
        }
        return $next($request);
    }
}
