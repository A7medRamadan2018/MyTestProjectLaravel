<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Seller;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(Admin $admin){
        return $admin->super_admin;
    }

    public function view(User $auth_user, User $target_user)
    {
        return $auth_user->id === $target_user->id;
    }

    public function update(User $auth_user, User $target_user)
    {
        return $auth_user->id === $target_user->id;
    }
}
