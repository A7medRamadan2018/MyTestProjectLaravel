<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\SellerRegisteredEvent;
use App\Events\SellerRegisteringEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerRequest\StoreSellerRequest;
use App\Http\Resources\SellerResource;
use App\Jobs\sendEmails;
use App\Models\Admin;
use App\Models\AprovedSeller;
use App\Models\Seller;
use App\Notifications\AdminNotificationFromSellerRegisteration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class SellerAuthentication extends Controller
{

    public function register(StoreSellerRequest $request)
    {
        $valid = $request->validated();
        $seller = Seller::create($valid);

        $image = $request->file('image');
        if ($image) {
            $file = $image->storeAs(
                'seller_images',
                'seller' . $seller->id . '_' . $image->getClientOriginalName(),
            );
            $seller->image()->create(
                ['url' => $file]
            );
        }
        return new SellerResource($seller->load('image'));
    }

}
