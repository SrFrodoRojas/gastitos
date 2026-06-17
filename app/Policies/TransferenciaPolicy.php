<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transferencia;

class TransferenciaPolicy
{
    public function view(User $user, Transferencia $transferencia): bool
    {
        return $user->id === $transferencia->user_id;
    }

    public function update(User $user, Transferencia $transferencia): bool
    {
        return $user->id === $transferencia->user_id;
    }

    public function delete(User $user, Transferencia $transferencia): bool
    {
        return $user->id === $transferencia->user_id;
    }
}
