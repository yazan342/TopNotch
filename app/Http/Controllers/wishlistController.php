<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function getUserWishlist()
    {
        $userId = Auth::id();
        $wishlist = Wishlist::where('user_id', $userId)->get();
        $products = [];
        foreach ($wishlist as $item) {
            $product = $item->product;
            $products[] = $product;
        }
        return response()->json([
            'wishlist' => (ProductResource::collection($products)),
        ]);
    }




    public function addToWishlist(Product $product)
    {
        $userId = Auth::user()->id;
        $wishlist = Wishlist::where('user_id', $userId)->where('product_id', $product->id)->first();

        if (!$wishlist) {
            $wishlistItem = new Wishlist();
            $wishlistItem->user_id = $userId;
            $wishlistItem->product_id = $product->id;
            $wishlistItem->save();

            return response()->json(['message' => 'Product added to wishlist']);
        }

        return response()->json(['message' => 'Product already in wishlist']);
    }


    public function removeFromWishlist(Product $product)
    {
        $user = Auth::user();
        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();

            return response()->json(['message' => 'Product removed from wishlist']);
        }

        return response()->json(['message' => 'Product not found in wishlist'], 400);
    }
}
