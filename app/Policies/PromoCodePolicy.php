<?php

namespace App\Policies;

use App\Models\PromoCode;
use App\Models\User;

class PromoCodePolicy
{
    public function view(User $user, PromoCode $promoCode): bool
    {
        return $user->id === $promoCode->organizer_id;
    }

    public function update(User $user, PromoCode $promoCode): bool
    {
        return $user->id === $promoCode->organizer_id;
    }

    public function delete(User $user, PromoCode $promoCode): bool
    {
        return $user->id === $promoCode->organizer_id;
    }
}
