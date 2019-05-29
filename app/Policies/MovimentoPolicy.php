<?php

namespace App\Policies;

use App\User;
use App\Movimento;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MovimentoPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Movimento $movimento)
    {
        return true;
    }

    public function create(User $user)
    {
        if ($user->isPiloto() || $user->isAdmin()) return true;
        return false;
    }

    public function store(User $user)
    {
        if ($user->isPiloto() || $user->isAdmin()) return true;
        return false;
    }

    public function update(User $user, Movimento $movimento)
    {
        if($movimento->isConfirmado()) return false;
        if($user->isAdmin() || $user->id === $movimento->piloto_id) return true;
        if(!$user->isPiloto()) return false;
        return false;
    }

    public function delete(User $user, Movimento $movimento)
    {   
        if($movimento->isConfirmado()) return false;
        if($user->isAdmin() || $user->id === $movimento->piloto_id) return true; 
        return false;
    }
}
