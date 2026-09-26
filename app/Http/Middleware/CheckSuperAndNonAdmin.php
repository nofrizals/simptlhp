<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAndNonAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAdmin = (
            (string) session('id') === '1' &&
            (string) session('level') === '1' &&
            (string) session('kode_unor') === '01.15'
        );

        $isLevelUser = in_array(
            (string) session('level'),
            ['2', '3', '4', '5'],
            true
        );

        if ($isAdmin || $isLevelUser) {
            return $next($request);
        }

        abort(403);
    }
}
