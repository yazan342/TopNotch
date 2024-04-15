<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\GenderCategory;

class SortController extends Controller
{
    public function sortProducts(Request $request)
    {
        $query = Product::query();

        if ($request->has('gender_category')) {
            $genderCategoryName = $request->input('gender_category');
            $genderCategory = GenderCategory::where('name', $genderCategoryName)->first();
            if ($genderCategory) {
                $query->where('genderCategory_id', $genderCategory->id)->where('status', Product::STATUS_ACCEPTED);
            }
        }


        if ($request->has('price')) {
            $sortPrice = $request->input('price');
            if ($sortPrice === 'high-to-low') {
                $query->where('status', Product::STATUS_ACCEPTED)->orderBy('price', 'desc');
            } elseif ($sortPrice === 'low-to-high') {
                $query->where('status', Product::STATUS_ACCEPTED)->orderBy('price', 'asc');
            }
        }

        if ($request->has('category')) {
            $categoryName = $request->input('category');
            $category = Category::where('name', $categoryName)->first();
            if ($category) {
                $query->where('category_id', $category->id)->where('status', Product::STATUS_ACCEPTED);
            }
        }


        $products = $query->where('status', Product::STATUS_ACCEPTED)->get();

        return response(ProductResource::collection($products));
    }
}
