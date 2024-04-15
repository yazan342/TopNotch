<!-- resources/views/user/profile.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">User Profile</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Profile Information</h5>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Address:</strong> {{ $user->address }}</p>
                        <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
                    </div>
                </div>
                <!-- Add more profile information as needed -->
            </div>
        </div>
    </div>
@endsection
