<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\StoreAdminRequest;
use App\Http\Requests\AdminRequest\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $this->authorize('viewAny', Admin::class);
        return AdminResource::collection(Admin::all());
    }
    public function show(Admin $admin)
    {
        $this->authorize('view', $admin);
        return new AdminResource($admin);
    }

    public function store(StoreAdminRequest $request)
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
        return new AdminResource($admin);
    }
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $this->authorize('update', $admin);
        $valid = $request->validated();
        $image = $request->file('image');
        if ($image) {
            $file = $image->store("AdminAccountsImage/admin_{$admin->id}");
            $admin->image()->update([
                'url' => $file,
            ]);
        }
        $admin->update($valid);
        return new AdminResource($admin);
    }
    public function destroy(Admin $admin)
    {
        $this->authorize('delete', $admin);
        $admin->delete();
        return response()->json([
            'message' => 'deleted successfully',
        ]);
    }
}
