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
        <!-- Main Profile Card -->
        <div class="card card-primary card-outline" style="max-width: 400px;"> <!-- Set maximum width -->
            <div class="card-header">
                <h3 class="card-title">Your Profile Information</h3>
            </div>
            <div class="card-body box-profile">
                <div class="text-center">
                    @if ($user->avatar)
                        <img class="profile-user-img img-fluid img-circle" 
                             src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="User profile picture"
                             style="width: 128px; height: 128px; object-fit: cover;"> <!-- Set fixed dimensions and maintain aspect ratio -->
                    @else
                        <i class="fas fa-user-circle" style="font-size: 128px; color: #ccc;"></i> <!-- Default icon -->
                    @endif
                </div>
                <h3 class="profile-username text-center" style="color: black;">{{ $user->name }}</h3> <!-- Ambil nama dari User -->
                <p class="text-muted text-center" style="color: black;">{{ $user->level->level_nama }}</p> <!-- Ambil level dari relasi -->
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Nama</b> <a class="float-right" style="color: black;">{{ $user->nama }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Username</b> <a class="float-right" style="color: black;">{{ $user->username }}</a> <!-- Ambil username dari User -->
                    </li>
                    <li class="list-group-item">
                        <b>Level</b> <a class="float-right" style="color: black;">{{ $user->level->level_nama }}</a>
                    </li>
                </ul>
                <!-- Form for Profile Picture Upload -->
                <div class="mb-3">
                    <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="avatar">Upload New Profile Picture:</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*" required>
                        <button type="submit" class="btn btn-primary mt-2">Upload Picture</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection