<?php

namespace App\Http\Middleware;

use App\Support\AdminAuth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = AdminAuth::user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if ($roles !== [] && ! in_array($user->role, $roles, true)) {
            return redirect()
                ->route('admin.dashboard')
                ->withErrors(['access' => 'You do not have permission to access that area.']);
        }

        return $next($request);
    }
}
