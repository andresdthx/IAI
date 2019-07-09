<?php

namespace App\Policies;

use App\User;
use App\Proyecto;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProyectoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\Proyecto  $proyecto
     * @return mixed
     */
    public function view(User $user, Proyecto $proyecto) {
       return ($user->hasAnyRole('admin') or $user->id == $proyecto->user_id);
    }

    /**
     * Determine whether the user can create proyectos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user) {
        return true;
    }

    /**
     * Determine whether the user can update the proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\Proyecto  $proyecto
     * @return mixed
     */
    public function update(User $user, Proyecto $proyecto) {
        return ($user->hasAnyRole('admin') or $user->id == $proyecto->user_id);
    }

    /**
     * Determine whether the user can delete the proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\Proyecto  $proyecto
     * @return mixed
     */
    public function delete(User $user, Proyecto $proyecto) {
        return ($user->hasAnyRole('admin') or $user->id == $proyecto->user_id);
    }
}
