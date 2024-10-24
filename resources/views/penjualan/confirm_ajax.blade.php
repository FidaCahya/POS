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
                             id="profile-pic" 
                             src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="User profile picture"
                             style="width: 128px; height: 128px; object-fit: cover;">
                    @else
                        <i class="fas fa-user-circle" style="font-size: 128px; color: #ccc;"></i> <!-- Default icon -->
                    @endif
                </div>
                <h3 class="profile-username text-center" style="color: black;">{{ $user->name }}</h3>
                <p class="text-muted text-center" style="color: black;">{{ $user->level->level_nama }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Nama</b> <a class="float-right" style="color: black;">{{ $user->nama }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Username</b> <a class="float-right" style="color: black;">{{ $user->username }}</a>
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
                
                <!-- Form for User Details Update -->
                <form id="edit-profile-form" method="POST" action="{{ url('profile/update_profile') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" required>
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ $user->nama }}" required>
                        @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>

                <!-- Button to open password change modal -->
                <button type="button" class="btn btn-secondary mt-3" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ url('profile/change_password') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script to preview selected image before uploading -->
<script>
    document.getElementById('avatar').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profile-pic');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

<!-- CSS Styling for preview -->
<style>
    #profile-pic {
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 50%;
        width: 200px;
        height: 200px;
    }
</style>
@endsection
