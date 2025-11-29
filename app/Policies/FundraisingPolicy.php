<?php

namespace App\Policies;

use App\Models\Fundraising;
use App\Models\User;

class FundraisingPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('organizer') || $user->hasRole('admin');
    }

    public function update(User $user, Fundraising $fundraising): bool
    {
        return $user->id === $fundraising->organizer_id || $user->hasRole('admin');
    }

    public function delete(User $user, Fundraising $fundraising): bool
    {
        return $user->id === $fundraising->organizer_id || $user->hasRole('admin');
    }
}


