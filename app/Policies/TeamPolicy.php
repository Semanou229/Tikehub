<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function view(User $user, Team $team): bool
    {
        return $team->organizer_id === $user->id;
    }

    public function update(User $user, Team $team): bool
    {
        return $team->organizer_id === $user->id;
    }

    public function delete(User $user, Team $team): bool
    {
        return $team->organizer_id === $user->id;
    }
}
