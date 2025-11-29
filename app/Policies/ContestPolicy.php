<?php

namespace App\Policies;

use App\Models\Contest;
use App\Models\User;

class ContestPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('organizer') || $user->hasRole('admin');
    }

    public function update(User $user, Contest $contest): bool
    {
        return $user->id === $contest->organizer_id || $user->hasRole('admin');
    }

    public function delete(User $user, Contest $contest): bool
    {
        return $user->id === $contest->organizer_id || $user->hasRole('admin');
    }
}


