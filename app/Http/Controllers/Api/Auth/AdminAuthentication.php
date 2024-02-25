<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\StoreAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminAuthentication extends Controller
{
    public function login(Request $request)
    {
        $valid = $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );

        $admin = Admin::where('email', $valid['email'])->first();
        if (!$admin)
            return response()->json(
                [
                    'message' => 'Invalid email address'
                ],
                404
            );

        if (!Hash::check($request->password, $admin->password))
            return response()->json(
                [
                    'message' => 'wrong password'
                ],
                404
            );
        $admin->tokens()->delete();
        return response()->json(
            [
                'message' => 'success Login',
                'id' => $admin->id,
                'email' => $admin->email,
                'token' => $admin->createToken('admin_token')->plainTextToken
            ],
            201
        );
    }

    public function register(StoreAdminRequest $request)
    {
        $valid = $request->validated();
        $admin = Admin::create($valid);
        $image = $request->file('image');
        if ($image) {
            $file = $image->store("AdminAccountsImage/admin_{$admin->id}");
            $admin->image()->create([
                'url' => $file,
            ]);
        }
        return new AdminResource($admin->load('image'));
    }
}
