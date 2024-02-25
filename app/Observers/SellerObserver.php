<?php

namespace App\Observers;

use App\Events\SellerRegisteredEvent;
use App\Events\SellerRegisteringEvent;
use App\Jobs\SendEmailToAdminWhileRegistering;
use App\Models\Seller;

class SellerObserver
{

    // public function creating(Seller $seller)
    // {
    // }

    /**
     * Handle the Seller "created" event.
     */
    public function created(Seller $seller): void
    {
        SellerRegisteredEvent::dispatch($seller);
    }

    /**
     * Handle the Seller "updated" event.
     */
    public function updated(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "deleted" event.
     */
    public function deleted(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "restored" event.
     */
    public function restored(Seller $seller): void
    {
        //
    }

    /**
     * Handle the Seller "force deleted" event.
     */
    public function forceDeleted(Seller $seller): void
    {
        //
    }
}
