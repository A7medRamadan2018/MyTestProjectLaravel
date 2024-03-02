<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class AdminPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(Admin $auth_admin)
    {
        return $auth_admin->super_admin;
    }
    public function view(Admin $auth_admin, Admin $target_admin)
    {
        return $auth_admin->id === $target_admin->id || $auth_admin->super_admin;
    }

    public function update(Admin $auth_admin, Admin $target_admin)
    {
        return $auth_admin->id === $target_admin->id;
    }
    public function delete(Admin $auth_admin, Admin $target_admin)
    {
        return $auth_admin->super_admin;
    }
}
