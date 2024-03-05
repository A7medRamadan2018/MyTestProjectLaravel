<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Seller;

class SellerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function viewAny(Admin $admin)
    {
        return $admin->super_admin;
    }
    public function view(Seller $auth_seller, Seller $target_seller)
    {
        return $auth_seller->id === $target_seller->id;
    }
    public function update(Seller $auth_seller, Seller $target_seller)
    {
        return $auth_seller->id === $target_seller->id;
    }
    public function delete(Admin $admin)
    {
        return $admin->super_admin;
    }
}
