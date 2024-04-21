<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdminRequest\StoreAdminRequest;
use App\Http\Requests\AdminRequest\UpdateAdminRequest;
use Illuminate\Support\Facades\Request;

class AdminController extends Controller
{
    private $path = "admin_images/";
    public function __construct()
    {
    }
    public function index()
    {
        $admin_id = auth()->guard('admin')->user()->id;
        $admins = Admin::where('id', '!=', $admin_id)
            ->where('super_admin', false)
            ->get();
        $response = [
            'admins' => AdminResource::collection($admins),
            'total_count' => $admins->count(),
        ];
        return response()->json($response);
    }
    public function show(Admin $admin)
    {
        $this->authorize('view', $admin);
        return new AdminResource($admin);
    }
    public function store(StoreAdminRequest $request)
    {
        $validatedData = $request->validated();
        $admin = Admin::create($validatedData);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file = $image->storeAs(
                'Admin_images',
                'Admin' . $admin->id . '_' . $image->getClientOriginalName(),
            );
            $admin->image()->create([
                'url' => $file,
            ]);
        }
        return new AdminResource($admin->load('image'));
    }
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $this->authorize('update', $admin);
        $valid = $request->validated();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            Storage::delete("{$this->path}/admin_{$admin->id}");
            $file = $image->store("{$this->path}/admin_{$admin->id}");
            $admin->image()->update([
                'url' => $file,
            ]);
        }
        $admin->update($valid);
        return new AdminResource($admin);
    }
    public function destroy(Admin $admin)
    {
        // dd($admin, auth()->guard('admin')->user());
        // $this->authorize('delete', $admin);
        $admin->delete();
        Storage::delete("{$this->path}/admin_{$admin->id}");
        return response()->json([
            'message' => 'deleted successfully',
        ]);
    }
}
