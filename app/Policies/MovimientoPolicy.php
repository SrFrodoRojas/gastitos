<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movimiento;

class MovimientoPolicy
{
    public function view(User $user, Movimiento $movimiento): bool
    {
        return $user->id === $movimiento->user_id;
    }

    public function update(User $user, Movimiento $movimiento): bool
    {
        return $user->id === $movimiento->user_id;
    }

    public function delete(User $user, Movimiento $movimiento): bool
    {
        return $user->id === $movimiento->user_id;
    }
}
