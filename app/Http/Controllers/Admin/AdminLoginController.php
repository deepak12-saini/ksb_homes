<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $password = config('app.admin_password', env('ADMIN_PASSWORD', 'admin'));
        $request->validate(['password' => 'required']);

        if ($request->input('password') === $password) {
            session(['admin_authenticated' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Invalid password.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        session()->forget('admin_authenticated');
        return redirect()->route('admin.login');
    }
}
