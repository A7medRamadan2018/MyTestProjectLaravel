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


    public function login(Request $request)
    {
        $valid = $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );

        $seller = Seller::where('email', $valid['email'])->first();
        if (!$seller)
            return response()->json(
                [
                    'message' => 'Invalid email address'
                ],
                404
            );
        if (!Hash::check($request->password, $seller->password))
            return response()->json(
                [
                    'message' => 'wrong password'
                ],
                404
            );
            $seller->tokens()->delete();

        return response()->json(
            [
                'message' => 'success Login',
                'id' => $seller->id,
                'email' => $seller->email,
                'token' => $seller->createToken('seller_token')->plainTextToken
            ],
            201
        );
    }

    public function register(StoreSellerRequest $request)
    {
        $valid = $request->validated();
        $seller = Seller::create($valid);

        $image = $request->file('image');
        if ($image) {
            $file = $image->store("SellerAccountsImage/seller{$seller->id}");
            $seller->image()->create(
                ['url' => $file]
            );
        }
        return new SellerResource($seller->load('image'));
    }
}
