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

    public function view(User $user, Movimento $movimento)
    {
        return true;
    }

    public function create(User $user)
    {

        if ($user->isPiloto()) return true;
        return false;
    }

    public function update(User $user, Movimento $movimento)
    {

        if ($movimento->pilotos->id==$user->id) return true;
        if ($movimento->intrutores!=null && $movimento->instrutores->id==$user->id) return true;
        return false;
    }

    public function delete(User $user, Movimento $movimento)
    {
        return false;
    }
}
