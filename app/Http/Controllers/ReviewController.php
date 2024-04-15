<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['exists:products,id'],
            'rating' => ['numeric', 'between:1,5'],
        ]);

        $review = Review::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if (!$review) {
            $review = new Review;
        }

        $review->product_id = $request->product_id;
        $review->user_id = Auth::id();
        $review->rating = $request->rating;
        $review->save();

        return new ReviewResource($review);
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $review = Review::where('product_id', $product->id)->where('user_id', Auth::id());
        $review->delete();

        return response()->json('deleted successfully', 200);
    }
}
