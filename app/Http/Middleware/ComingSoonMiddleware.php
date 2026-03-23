<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * When APP_COMING_SOON is true, every web request gets the coming-soon page.
 * Independent of Laravel's php artisan down maintenance mode.
 */
class ComingSoonMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('app.coming_soon')) {
            return $next($request);
        }

        // Laravel's built-in health check (not in web group on default install, but safe if it is)
        if ($request->is('up')) {
            return $next($request);
        }

        return response()
            ->view('coming-soon', [], Response::HTTP_OK)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }
}
