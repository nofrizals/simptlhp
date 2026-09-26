<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            (string) session('id') === '1' &&
            (string) session('level') === '1' &&
            (string) session('kode_unor') === '01.15'
        ) {
            return $next($request);
        }

        abort(403);
    }
}
