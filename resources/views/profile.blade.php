@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Profile</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>
        </div>

        <h3>Change Password</h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update-password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required>
                @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    </div>
@endsection
