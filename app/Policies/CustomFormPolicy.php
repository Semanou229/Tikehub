<?php

namespace App\Policies;

use App\Models\CustomForm;
use App\Models\User;

class CustomFormPolicy
{
    public function view(User $user, CustomForm $form): bool
    {
        return $form->organizer_id === $user->id;
    }

    public function update(User $user, CustomForm $form): bool
    {
        return $form->organizer_id === $user->id;
    }

    public function delete(User $user, CustomForm $form): bool
    {
        return $form->organizer_id === $user->id;
    }
}
