<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function getUserCart()
    {
        $userId = Auth::id();


        $cart = Cart::where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Retrieve the newest cart
            ->with('cartProducts.product')
            ->first();

        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->save();
        }


        $response = $cart->cartProducts->map(function ($cartProduct) {
            return [
                'product' => new ProductResource($cartProduct->product),
                'quantity' => $cartProduct->quantity,
            ];
        });

        $cartProducts = CartProduct::where('cart_id', $cart->id)->get();


        $totalPrice = 0;
        $discountPercentage = 0;
        $totalQuantities = 0;
        foreach ($cartProducts as $cartProduct) {
            $product = Product::find($cartProduct->product_id);
            $totalPrice += ($product->price * $cartProduct->quantity);
            if ($cartProduct->quantity > 1) {
                $totalQuantities += $cartProduct->quantity - 1;
            }
        }



        if (count($cartProducts) + $totalQuantities  >= 5 && count($cartProducts) + $totalQuantities < 10) {
            $discountPercentage = 15;
        } elseif (count($cartProducts) + $totalQuantities >= 10 && count($cartProducts) + $totalQuantities < 15) {
            $discountPercentage = 30;
        } elseif (count($cartProducts) + $totalQuantities > 15) {
            $discountPercentage = 50;
        }

        $discountAmount = ($totalPrice * $discountPercentage) / 100;
        $finalPrice = $totalPrice - $discountAmount;


        return response()->json(['cart' => $response, 'totalPrice' => $finalPrice]);
    }
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = isset($request->quantity) ? $request->input('quantity') : 1;
        $userId = $request->user()->id;


        $cart = Cart::where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Retrieve the newest cart
            ->with('cartProducts.product')
            ->first();

        if (!$cart) {

            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->save();
        }


        $product = Product::find($productId);
        $cartProduct = CartProduct::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($product->quantity < $quantity) {
            return response()->json(['message' => 'Insufficient stock quantity'], 400);
        }

        if ($cartProduct) {
            if (($product->quantity) - ($cartProduct->quantity) < $quantity) {
                return response()->json(['message' => 'Insufficient stock quantity'], 400);
            }
        }

        if ($cartProduct) {
            $cartProduct->quantity += $quantity;
            $cartProduct->save();
        } else {
            $cartProduct = new CartProduct();
            $cartProduct->cart_id = $cart->id;
            $cartProduct->product_id = $productId;
            $cartProduct->quantity = $quantity;
            $cartProduct->save();
        }

        return response()->json(['message' => 'Product added to cart successfully']);
    }


    public function removeProductFromCart($productId)
    {
        $userId = Auth::id();


        $cart = Cart::where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Retrieve the newest cart
            ->with('cartProducts.product')
            ->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 400);
        }

        $cartProduct = CartProduct::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if (!$cartProduct) {
            return response()->json(['message' => 'Product not found in cart'], 400);
        }

        if ($cartProduct->quantity > 1) {
            $cartProduct->quantity -= 1;
            $cartProduct->save();
        } else {
            $cartProduct->delete();
        }

        return response()->json(['message' => 'Product removed from cart successfully']);
    }

    public function deleteProductFromCart($productId)
    {
        $userId = Auth::id();

        $cart = Cart::where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Retrieve the newest cart
            ->with('cartProducts.product')
            ->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 400);
        }

        $cartProduct = CartProduct::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if (!$cartProduct) {
            return response()->json(['message' => 'Product not found in cart'], 400);
        }

        $cartProduct->delete();

        return response()->json(['message' => 'Product deleted from cart successfully']);
    }

    public function emptyCart()
    {
        $userId = Auth::id();

        $cart = Cart::where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Retrieve the newest cart
            ->with('cartProducts.product')
            ->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 400);
        }


        CartProduct::where('cart_id', $cart->id)->delete();

        return response()->json(['message' => 'Cart emptied successfully']);
    }
}
