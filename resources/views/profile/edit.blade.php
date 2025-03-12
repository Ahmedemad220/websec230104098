@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Edit Profile</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Profile Update Form -->
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <hr>

    <!-- Password Change Form -->
    <h3>Change Password</h3>
    <form action="{{ route('profile.update-password') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password:</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">New Password:</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Confirm New Password:</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-danger">Change Password</button>
    </form>
