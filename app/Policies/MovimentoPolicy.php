<?php

namespace App\Policies;

use App\User;
use App\Movimento;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovimentoPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        
    }

    public function view(User $user, Movimento $model)
    {
        return true;
    }

    public function create(User $user)
    {

        if ($user->isPiloto()) return true;
        return false;
    }

    public function update(User $user, Movimento $model)
    {
        return false;
    }

    public function delete(User $user, Movimento $model)
    {
        return false;
    }
}
