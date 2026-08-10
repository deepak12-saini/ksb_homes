<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\AdminAuth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        $user = User::where('email', $credentials['username'])->first();

        if (! $user || ! $this->passwordMatches($user, $credentials['password'])) {
            return back()
                ->withErrors(['username' => 'Invalid username or password.'])
                ->withInput($request->only('username'));
        }

        // Upgrade legacy MD5 hashes to bcrypt on successful login.
        if ($this->isLegacyMd5($user->getRawOriginal('password') ?? $user->password, $credentials['password'])) {
            $user->password = $credentials['password'];
            $user->save();
        }

        if (! in_array($user->role, [User::ROLE_ADMIN, User::ROLE_MARKETING], true)) {
            $user->role = User::ROLE_ADMIN;
            $user->save();
        }

        AdminAuth::login($user);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        AdminAuth::logout();

        return redirect()->route('admin.login');
    }

    private function passwordMatches(User $user, string $plain): bool
    {
        $stored = $user->getRawOriginal('password') ?? $user->password;

        if (! is_string($stored) || $stored === '') {
            return false;
        }

        // Laravel's Hash::check() throws if the stored value is not bcrypt (e.g. legacy MD5).
        if ($this->isBcryptHash($stored)) {
            try {
                return Hash::check($plain, $stored);
            } catch (\RuntimeException $e) {
                return false;
            }
        }

        return $this->isLegacyMd5($stored, $plain);
    }

    private function isBcryptHash(string $stored): bool
    {
        return (bool) preg_match('/^\$2[ayb]\$/', $stored);
    }

    private function isLegacyMd5(mixed $stored, string $plain): bool
    {
        return is_string($stored)
            && strlen($stored) === 32
            && ctype_xdigit($stored)
            && hash_equals(strtolower($stored), md5($plain));
    }
}