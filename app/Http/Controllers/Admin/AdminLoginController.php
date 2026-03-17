<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // NOTE: This uses MD5 for compatibility with an existing database.
        // MD5 is not recommended for new applications.
        $user = User::where('email', $credentials['username'])->first();

        if ($user && $user->password === md5($credentials['password'])) {
            session(['admin_authenticated' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors(['username' => 'Invalid username or password.'])
            ->withInput($request->only('username'));
    }

    public function logout(Request $request): RedirectResponse
    {
        session()->forget('admin_authenticated');
        return redirect()->route('admin.login');
    }
}
