<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mt-4">Dashboard</h1>
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title mb-4">Visitors</h2>
                <p class="card-text text-center display-3">{{ $visitors }}</p>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <h2>Pending Products</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('product.show', $product->id) }}"
                                        class="text-primary font-weight-bold">{{ $product->name }}</a>
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $product->status === App\Models\Product::STATUS_PENDING ? 'badge-warning' : ($product->status === App\Models\Product::STATUS_ACCEPTED ? 'badge-success' : 'badge-danger') }}">
                                        {{ $product->getStatusText() }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('product.accept', $product->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                    </form>
                                    <form action="{{ route('product.reject', $product->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($products) > 5)
                    <p class="text-muted small mt-2">Scroll to view more</p>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <h2>All Users</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form action="{{ route('user.delete', $user->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <a href="{{ route('user.profile', $user->id) }}"
                                        class="btn btn-primary btn-sm ml-2">View Profile</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($users) > 5)
                    <p class="text-muted small mt-2">Scroll to view more</p>
                @endif
            </div>
        </div>
    </div>
@endsection
