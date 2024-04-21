<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdminResource;
use App\Http\Requests\AdminRequest\StoreAdminRequest;

class AdminAuthentication extends Controller
{
    public function register(StoreAdminRequest $request)
    {
        $valid = $request->validated();
        $admin = Admin::create($valid);
        $image = $request->file('image');
        if ($image) {
            $url = $image->storeAs(
                'admin_images',
                'admin' . $admin->id . '_' . $image->getClientOriginalName(),
            );
            $admin->image()->create(
                ['url' => $url]
            );
        }
        return new AdminResource($admin->load('image'));
    }


}
