<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    public function view(Seller $seller, Product $product)
    {
        return $seller->id === $product->seller_id;
    }

    public function update(Seller $seller, Product $product)
    {
        return $seller->id === $product->seller_id;
    }
    public function delete(Seller $seller, Product $product)
    {
        return $seller->id === $product->seller_id;
    }
}
