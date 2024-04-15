<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function createOrder()
    {

        $userId = Auth::id();


        $cart = Cart::where('user_id', $userId)
            ->orderBy('created_at', 'desc')->first();


        if (!$cart) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }


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
            $product->quantity -= $cartProduct->quantity;
            if ($product->quantity == 0) {
                $product->status = Product::STATUS_SOLD;
            }
            $product->save();
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


        $order = new Order();
        $order->total_price = $finalPrice;
        $order->status = 'pending';
        $order->cart_id = $cart->id;
        $order->created_at = Carbon::now()->toDateString();
        $order->save();


        $newCart = new Cart();
        $newCart->user_id = $userId;
        $newCart->save();

        return response()->json(['message' => 'Order created successfully'], 200);
    }

    public function showUserOrders()
    {
        $user = Auth::user();

        $orderedProducts = $user->cart()
            ->with(['cartProducts.product', 'cartProducts.cart.order'])
            ->get()
            ->pluck('cartProducts')
            ->flatten()
            ->pluck('product')
            ->unique('id');

        return response()->json(ProductResource::collection($orderedProducts));
    }
}
