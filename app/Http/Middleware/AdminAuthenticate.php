<?php

namespace App\Http\Middleware;

use App\Support\AdminAuth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = AdminAuth::user();

        if (! $user) {
            AdminAuth::logout();

            return redirect()->route('admin.login');
        }

        // Keep role in session in sync if changed in DB.
        if (session('admin_role') !== $user->role) {
            session(['admin_role' => $user->role]);
        }

        $request->attributes->set('adminUser', $user);
        view()->share('adminUser', $user);

        return $next($request);
    }
}
