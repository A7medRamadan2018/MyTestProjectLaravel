<?php

namespace App\RepositoryInterface;

use App\Models\Order;

interface IOrderRepository
{
    public function getAllForUser($user);
    public function show(Order $order);
    public function create(array $data, int $userId);
    public function update(Order $order, array $data);
    public function delete(Order $order);
}
