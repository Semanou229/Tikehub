<?php

namespace App\Policies;

use App\Models\Automation;
use App\Models\User;

class AutomationPolicy
{
    public function view(User $user, Automation $automation): bool
    {
        return $automation->organizer_id === $user->id;
    }

    public function update(User $user, Automation $automation): bool
    {
        return $automation->organizer_id === $user->id;
    }

    public function delete(User $user, Automation $automation): bool
    {
        return $automation->organizer_id === $user->id;
    }
}
