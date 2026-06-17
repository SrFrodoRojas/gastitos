<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CompraTarjeta;

class CompraTarjetaPolicy
{
    public function view(User $user, CompraTarjeta $compraTarjeta): bool
    {
        $tarjeta = $compraTarjeta->tarjeta()->first();

        return $tarjeta !== null
            && $user->id === $tarjeta->user_id;
    }

    public function update(User $user, CompraTarjeta $compraTarjeta): bool
    {
        $tarjeta = $compraTarjeta->tarjeta()->first();

        return $tarjeta !== null
            && $user->id === $tarjeta->user_id;
    }

    public function delete(User $user, CompraTarjeta $compraTarjeta): bool
    {
        $tarjeta = $compraTarjeta->tarjeta()->first();

        return $tarjeta !== null
            && $user->id === $tarjeta->user_id;
    }
}
