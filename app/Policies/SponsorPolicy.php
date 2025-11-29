<?php

namespace App\Policies;

use App\Models\Sponsor;
use App\Models\User;

class SponsorPolicy
{
    public function view(User $user, Sponsor $sponsor): bool
    {
        return $sponsor->organizer_id === $user->id;
    }

    public function update(User $user, Sponsor $sponsor): bool
    {
        return $sponsor->organizer_id === $user->id;
    }

    public function delete(User $user, Sponsor $sponsor): bool
    {
        return $sponsor->organizer_id === $user->id;
    }
}
