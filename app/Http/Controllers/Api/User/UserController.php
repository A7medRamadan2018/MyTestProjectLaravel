<?php
namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest\StoreUserRequest;
use App\Http\Requests\UserRequest\UpdateUserRequest;
use App\Models\Admin;

class UserController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $this->authorize('viewAny', Admin::class);
        return UserResource::collection(User::all());
    }
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $valid = $request->validated();
        $user = User::create($valid);
        $image = $request->file('image');
        if ($image) {
            $file = $image->store("UserAccountsImage/User_{$user->id}");
            $user->image()->create([
                'url' => $file,
            ]);
        }
        return new UserResource($user);
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        $valid = $request->validated();
        $image = $request->file('image');
        if ($image) {
            $file = $image->store("UserAccountsImage/User_{$user->id}");
            $user->image()->update([
                'url' => $file,
            ]);
        }
        $user->update($valid);
        return new UserResource($user);
    }
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json([
            'message' => 'deleted successfully',
        ]);
    }
}
