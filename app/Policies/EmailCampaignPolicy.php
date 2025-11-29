<?php

namespace App\Policies;

use App\Models\EmailCampaign;
use App\Models\User;

class EmailCampaignPolicy
{
    public function view(User $user, EmailCampaign $campaign): bool
    {
        return $campaign->organizer_id === $user->id;
    }

    public function update(User $user, EmailCampaign $campaign): bool
    {
        return $campaign->organizer_id === $user->id;
    }

    public function delete(User $user, EmailCampaign $campaign): bool
    {
        return $campaign->organizer_id === $user->id;
    }
}
