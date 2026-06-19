<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MovimientoRecurrente;

class MovimientoRecurrentePolicy
{
    public function view(User $user, MovimientoRecurrente $recurrente): bool
    {
        return $user->id === $recurrente->user_id;
    }

    public function update(User $user, MovimientoRecurrente $recurrente): bool
    {
        return $user->id === $recurrente->user_id;
    }

    public function delete(User $user, MovimientoRecurrente $recurrente): bool
    {
        return $user->id === $recurrente->user_id;
    }
}
