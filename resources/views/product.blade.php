<!-- resources/views/product.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Product Details</h1>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title mb-3">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                        <p class="card-text"><strong>Quantity:</strong> {{ $product->quantity }}</p>
                        <p class="card-text"><strong>Category:</strong> {{ $product->category->name }}</p>
                        <p class="card-text"><strong>Seller:</strong> {{ $product->seller->name }}</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="{{ url('images/' . $product->image) }}" alt="Product Image"
                            class="img-fluid rounded-circle product-image" style="max-width: 300px; max-height: 300px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
