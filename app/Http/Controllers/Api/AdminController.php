<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\StoreAdminRequest;
use App\Http\Requests\AdminRequest\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.super.admin');
    }
    public function index()
    {
        return AdminResource::collection(Admin::all());
    }
    public function show(Admin $admin)
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin->super_admin)
            return response()->json(['message' => 'unauthorized']);
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
    public function delete(Admin $admin)
    {

        $admin->delete();
        return response()->json([
            'message' => 'deleted successfully',
        ]);
    }
}
