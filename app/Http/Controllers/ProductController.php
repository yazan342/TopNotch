<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\GenderCategory;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->where('status', Product::STATUS_ACCEPTED)->get();
        return response(ProductResource::collection($products));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'quantity' => 'required|integer|min:0',
            'category' => 'required|string|exists:categories,name',
            'genderCategory' => 'required|string|exists:genderCategories,name',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);
        $category_id = Category::where('name', $request->category)->first();
        $category_id = $category_id->id;
        $genderCategory_id = GenderCategory::where('name', $request->genderCategory)->first();
        $genderCategory_id = $genderCategory_id->id;
        $product = new Product;
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->image = $imageName;
        $product->quantity = $validatedData['quantity'];
        $product->category_id = $category_id;
        $product->genderCategory_id = $genderCategory_id;
        $product->seller_id = auth()->id();
        $product->save();

        return response(new ProductResource($product));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response(new ProductResource($product));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
            'quantity' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'genderCategory_id' => 'sometimes|exists:genderCategories,id',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        if (isset($validatedData['name'])) {
            $product->name = $validatedData['name'];
        }

        if (isset($validatedData['description'])) {
            $product->description = $validatedData['description'];
        }

        if (isset($validatedData['price'])) {
            $product->price = $validatedData['price'];
        }

        if (isset($validatedData['quantity'])) {
            $product->quantity = $validatedData['quantity'];
        }

        if (isset($validatedData['category_id'])) {
            $product->category_id = $validatedData['category_id'];
        }

        if (isset($validatedData['genderCategory_id'])) {
            $product->genderCategory_id = $validatedData['genderCategory_id'];
        }

        $product->save();

        return response(new ProductResource($product->fresh()));
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    public function getUserProducts()
    {
        $userId = Auth::user()->id;

        $products = Product::where('seller_id', $userId)->where('status', Product::STATUS_ACCEPTED)->get();

        return response(ProductResource::collection($products));
    }
}
