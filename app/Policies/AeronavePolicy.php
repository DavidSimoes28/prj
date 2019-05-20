<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AeronavePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return $user->isAdmin();
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
        return false;
    }

    public function delete(User $user, user $model)
    {
        return false;
    }
}
