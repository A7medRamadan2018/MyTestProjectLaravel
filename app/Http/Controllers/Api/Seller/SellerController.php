<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerRequest\StoreSellerRequest;
use App\Http\Requests\SellerRequest\UpdateSellerRequest;
use App\Http\Resources\SellerResource;
use App\Models\Admin;
use App\Models\Seller;

class SellerController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $this->authorize('viewAny', Admin::class);
        return SellerResource::collection(Seller::all());
    }
    public function show(Seller $Seller)
    {
        $this->authorize('view', $Seller);
        return new SellerResource($Seller);
    }

    public function store(StoreSellerRequest $request)
    {
        $valid = $request->validated();
        $seller = Seller::create($valid);
        $image = $request->file('image');
        if ($image) {
            $file = $image->store("SellerAccountsImage/Seller_{$seller->id}");
            $seller->image()->create([
                'url' => $file,
            ]);
        }
        return new SellerResource($seller);
    }
    public function update(UpdateSellerRequest $request, Seller $seller)
    {
        $valid = $request->validated();
        $image = $request->file('image');
        if ($image) {
            $file = $image->store("SellerAccountsImage/Seller_{$seller->id}");
            $seller->image()->update([
                'url' => $file,
            ]);
        }
        $seller->update($valid);
        return new SellerResource($seller);
    }
    public function destroy(Seller $seller)
    {
        $this->authorize('delete', $seller);
        $seller->delete();
        return response()->json([
            'message' => 'deleted successfully',
        ]);
    }
}
