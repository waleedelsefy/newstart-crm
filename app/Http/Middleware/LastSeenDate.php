<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastSeenDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->last_seen_date < Carbon::now()->subMinutes(3)->format('Y-m-d H:i:s')) {
            $user->last_seen_date = now();
            $user->saveQuietly();
        }

        return $next($request);
    }
}
