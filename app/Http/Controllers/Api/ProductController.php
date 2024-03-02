<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest\StoreProductRequest;
use App\Http\Requests\ProductRequest\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use App\Models\Seller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $seller_products = Product::where('seller_id', auth()->guard('seller')->user()->id)->get();
        return ProductResource::collection($seller_products);
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return new ProductResource($product);
    }
    public function store(StoreProductRequest $request)
    {
        $validProduct = $request->validated();
        $validProduct['seller_id'] = Auth::guard('seller')->user()->id;
        $product = Product::create($validProduct);
        $images = $request->file('images');
        foreach ($images as $image) {
            $path = $image->store("/products/product_{$product->id}");
            $product->images()->create([
                'url' => $path,
            ]);
        }
        $product = $product->load('images');
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $validProduct = $request->validated();
        $product->update($validProduct);
        $images = $request->file('images');
        foreach ($images as $image) {
            $path = $image->store("/products/product_{$product->id}");
            $product->images()->create([
                'url' => $path,
            ]);
        }
        $product = $product->load('images');
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return response()->noContent();
    }
}
