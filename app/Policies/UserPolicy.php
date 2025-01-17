<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ( $user->isAdmin() ) return true;
    }

    public function view(User $user, user $model)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, user $model)
    {
        return $user->id == $model->id;
    }

    public function delete(User $user, user $model)
    {
        return false;
    }
}
