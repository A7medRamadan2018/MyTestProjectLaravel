<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest\StoreCategoryRequest;
use App\Http\Requests\CategoryRequest\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $categories = Category::where('admin_id', $admin->id)->get();
        return CategoryResource::collection($categories)->additional(['admin' => Auth::user('admin')]);;
    }
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
    public function store(StoreCategoryRequest $request)
    {
        $validcategory = $request->validated();
        $validcategory['admin_id'] = Auth::guard('admin')->user()->id;
        $category = Category::create($validcategory);
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validcategory = $request->validated();
        $category->update($validcategory);
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
