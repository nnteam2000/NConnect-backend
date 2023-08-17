<?php

namespace App\Policies;

use App\Models\User;

class AuthorPolicy
{
    public function isAuthor(?User $user, int|string $user_id): bool
    {
        return $user->id === $user_id;
    }
}
