<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Etiqueta;

class EtiquetaPolicy
{
    public function view(User $user, Etiqueta $etiqueta): bool
    {
        return $user->id === $etiqueta->user_id;
    }

    public function update(User $user, Etiqueta $etiqueta): bool
    {
        return $user->id === $etiqueta->user_id;
    }

    public function delete(User $user, Etiqueta $etiqueta): bool
    {
        return $user->id === $etiqueta->user_id;
    }
}
