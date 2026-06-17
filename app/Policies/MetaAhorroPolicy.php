<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MetaAhorro;

class MetaAhorroPolicy
{
    public function view(
        User $user,
        MetaAhorro $metaAhorro
    ): bool {
        return $user->id === $metaAhorro->user_id;
    }

    public function update(
        User $user,
        MetaAhorro $metaAhorro
    ): bool {
        return $user->id === $metaAhorro->user_id;
    }

    public function delete(
        User $user,
        MetaAhorro $metaAhorro
    ): bool {
        return $user->id === $metaAhorro->user_id;
    }
}
