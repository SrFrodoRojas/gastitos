<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TarjetaCredito;

class TarjetaCreditoPolicy
{
    public function view(
        User $user,
        TarjetaCredito $tarjetaCredito
    ): bool {
        return $user->id === $tarjetaCredito->user_id;
    }

    public function update(
        User $user,
        TarjetaCredito $tarjetaCredito
    ): bool {
        return $user->id === $tarjetaCredito->user_id;
    }

    public function delete(
        User $user,
        TarjetaCredito $tarjetaCredito
    ): bool {
        return $user->id === $tarjetaCredito->user_id;
    }
}
