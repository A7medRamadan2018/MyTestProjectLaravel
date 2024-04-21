<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Seller;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $valid = $request->validated();
        $currentRoute = Route::current();
        $routeAttributes = $currentRoute->getAction();
        $user_type =  Str::substr($routeAttributes['prefix'],  4);
        switch ($user_type) {
            case 'admins':
                $user = Admin::where('email', $valid['email'])->first();
                break;
            case 'sellers':
                $user = Seller::where('email', $valid['email'])->first();
                break;
            case 'users':
                $user = User::where('email', $valid['email'])->first();
                break;
        }
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
                'token' => $user->createToken('admin_token')->plainTextToken
            ],
            201
        );
    }
}
