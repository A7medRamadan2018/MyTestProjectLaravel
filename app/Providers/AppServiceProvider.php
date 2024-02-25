<?php

namespace App\Providers;

use App\Models\Seller;
use App\Observers\SellerObserver;
use App\Repository\OrderRepository;
use App\RepositoryInterface\IOrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
    {
        // Seller::observe(SellerObserver::class);
    }
}
