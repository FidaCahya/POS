@extends('layouts.tamplate') <!-- Ensure you have the correct main layout -->

@section('title', 'Profile')

@section('content')
<!-- Display success message if available -->
@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-5">
    <div class="d-flex justify-content-center"> <!-- Center the card -->
        <div class="card" style="width: 600px;"> <!-- Set card width -->
            <div class="card-header text-center">
                <h3 class="card-title">Your Profile Information</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @if ($user->avatar)
                        <img class="profile-user-img img-fluid img-circle" 
                             src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="User profile picture"
                             style="width: 128px; height: 128px; object-fit: cover;">
                    @else
                        <i class="fas fa-user-circle" style="font-size: 128px; color: #ccc;"></i>
                    @endif
                </div>
                <h4 class="profile-username text-center" style="color: black;">{{ $user->nama }}</h4>
                <p class="text-muted text-center" style="color: black;">{{ $user->level->level_nama }}</p>

                <hr>

                <!-- Form for Profile Picture Upload -->
                <h5>Upload Profile Picture</h5>
                <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                    @csrf
                    <input type="file" name="avatar" class="form-control mb-2" accept="image/*" required>
                    <button type="submit" class="btn btn-primary btn-block">Upload Picture</button>
                </form>

                <hr>

                <!-- Form for Profile Update -->
                <h5>Update Profile Information</h5>
                <form action="{{ route('profile.update') }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT') <!-- Use PUT method for update -->
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Update Profile</button>
                </form>

                <hr>

                <!-- Form for Change Password -->
                <h5>Change Password</h5>
                <form action="{{ route('profile.change-password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
