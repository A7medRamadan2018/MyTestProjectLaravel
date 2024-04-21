<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthentication extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file = $image->storeAs(
                'user_images',
                'user' . $user->id . '_' . $image->getClientOriginalName(),
            );
            $user->image()->create([
                'url' => $file,
            ]);
        }
        return new UserResource($user->load('image'));
    }
}
