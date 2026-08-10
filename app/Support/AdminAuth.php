<?php

namespace App\Support;

use App\Models\User;

class AdminAuth
{
    public static function user(): ?User
    {
        $id = session('admin_user_id');
        if (! $id) {
            return null;
        }

        return User::query()->find($id);
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function isAdmin(): bool
    {
        $user = self::user();

        return $user !== null && $user->isAdmin();
    }

    public static function login(User $user): void
    {
        session([
            'admin_authenticated' => true,
            'admin_user_id' => $user->id,
            'admin_role' => $user->role ?: User::ROLE_ADMIN,
        ]);
    }

    public static function logout(): void
    {
        session()->forget(['admin_authenticated', 'admin_user_id', 'admin_role']);
    }
}
