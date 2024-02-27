<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserAuthentication extends Controller
{
    public function login(Request $request)
    {
        $valid = $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ]
        );

        $user = User::where('email', $valid['email'])->first();
        if (!$user)
            return response()->json(
                [
                    'message' => 'Invalid email address'
                ],
                404
            );
        if (!Hash::check($request->password, $user->password))
            return response()->json(
                [
                    'message' => 'wrong password'
                ],
                404
            );
        $user->tokens()->delete();

        return response()->json(
            [
                'message' => 'success Login',
                'id' => $user->id,
                'email' => $user->email,
                'token' => $user->createToken('user_token')->plainTextToken
            ],
            201
        );
    }

    public function register(StoreUserRequest $request)
    {
        $valid = $request->validated();
        $user = user::create($valid);
        $image = $request->file('image');
        if ($image) {
            $file = $image->store("UserAccountsImage/user_{$user->id}");
            $user->image()->create([
                'url' => $file,
            ]);
            return new UserResource($user->load('image'));
        }
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return  response()->json(
            [
                'message' => 'logout successful'
            ]
        );
    }
}
