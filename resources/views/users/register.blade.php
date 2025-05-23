@extends('layouts.master')
@section('title', 'Register')
@section('content')
  <div class="d-flex justify-content-center">
    <div class="card m-4 col-sm-6">
      <div class="card-body"></div>
      <form action="{{ route('do_register') }}" method="post">
      {{ csrf_field() }}

      <!-- Error Handling -->
      <div class="form-group">
        @foreach($errors->all() as $error)
          <div class="alert alert-danger">
              <strong>Error!</strong> {{ $error }}
          </div>
        @endforeach
      </div>

      <!-- Name Field -->
      <div class="form-group mb-2">
        <label for="name" class="form-label">Name:</label>
        <input type="text" class="form-control" placeholder="Enter your name" name="name" required
        aria-describedby="nameHelp">
      </div>

      <!-- Email Field -->
      <div class="form-group mb-2">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" placeholder="Enter your email" name="email" required
        aria-describedby="emailHelp">
      </div>

      <!-- Password Field -->
      <div class="form-group mb-2">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" placeholder="Enter your password" name="password" required
        aria-describedby="passwordHelp">
      </div>

      <!-- Password Confirmation Field -->
      <div class="form-group mb-2">
        <label for="password_confirmation" class="form-label">Password Confirmation:</label>
        <input type="password" class="form-control" placeholder="Confirm your password" name="password_confirmation"
        required aria-describedby="passwordConfirmationHelp">
      </div>

      <!-- Submit Button -->
      <div class="form-group mb-2 text-center">
        <button type="submit" class="btn btn-primary w-100 mb-2">Register</button>
        <a href="{{ route('google.login') }}" class="btn btn-outline-primary mx-1">
                <img src="images/google.png" alt="Google Logo" style="width: 30px; height: 30px;">
              </a>
              <a href="{{ route('facebook.login') }}" class="btn btn-outline-primary mx-1">
                <img src="{{ asset('images/facebooklogo.png') }}" alt="Facebook Logo" style="width: 30px; height: 30px;">
              </a>
              <a href="{{ route('github.redirect') }}" class="btn btn-outline-primary mx-1">
                <img src="images/github.png" alt="GitHub Logo" style="width: 30px; height: 30px;">
              </a>
              
      </div>
      </form>
    </div>
    </div>
  </div>
@endsection