<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CuotaTarjeta;

class CuotaTarjetaPolicy
{
    public function view(User $user, CuotaTarjeta $cuotaTarjeta): bool
    {
        return $user->id ===
            $cuotaTarjeta->compra
                ->tarjeta
                ->user_id;
    }
}
