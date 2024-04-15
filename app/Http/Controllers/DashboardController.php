<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::where('status', Product::STATUS_PENDING)->get();
        $users = User::all();
        $visitors = count(User::all());
        return view('dashboard', compact('products', 'users', 'visitors'));
    }
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('user.profile', ['user' => $user]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('dashboard')->with('success', 'User deleted successfully.');
    }
    public function acceptProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->status = Product::STATUS_ACCEPTED;
        $product->save();

        return redirect()->route('dashboard')->with('success', 'Product accepted successfully.');
    }

    public function rejectProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->status = Product::STATUS_SOLD;
        $product->save();

        return redirect()->route('dashboard')->with('success', 'Product rejected successfully.');
    }
    public function show($id)
    {
        $product = Product::with('category', 'seller')->findOrFail($id);

        return view('product', compact('product'));
    }
}
