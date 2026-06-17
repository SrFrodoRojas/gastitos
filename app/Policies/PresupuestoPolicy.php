<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Presupuesto;

class PresupuestoPolicy
{
    public function view(User $user, Presupuesto $presupuesto): bool
    {
        return $user->id === $presupuesto->user_id;
    }

    public function update(User $user, Presupuesto $presupuesto): bool
    {
        return $user->id === $presupuesto->user_id;
    }

    public function delete(User $user, Presupuesto $presupuesto): bool
    {
        return $user->id === $presupuesto->user_id;
    }
}
