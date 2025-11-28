<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('organizer') || $user->hasRole('admin');
    }

    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id 
            || $user->hasRole('admin')
            || $event->agents()->where('agent_id', $user->id)->exists();
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id || $user->hasRole('admin');
    }

    public function publish(User $user, Event $event): bool
    {
        return $this->update($user, $event);
    }
}

