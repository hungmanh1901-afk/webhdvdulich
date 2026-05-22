<?php

namespace App\Support;

use App\Models\User;

class AuthRedirect
{
    public static function pathFor(User $user): string
    {
        return $user->isAdmin()
            ? route('admin.dashboard')
            : route('home');
    }
}
