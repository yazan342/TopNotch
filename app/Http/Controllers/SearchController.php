<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        if (!$searchTerm) {
            return response()->json(['error' => 'Search term is required.'], 400);
        }

        $products = Product::where('name', 'LIKE', "%{$searchTerm}%")->where('status', Product::STATUS_ACCEPTED)->get();

        return ProductResource::collection($products);
    }
}
