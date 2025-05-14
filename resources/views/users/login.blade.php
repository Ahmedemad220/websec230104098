@extends('layouts.master')

@section('title', 'Login')

@section('content')
  <div class="d-flex justify-content-center">
    <div class="card m-4 col-sm-6">
      <div class="card-body">
        <form action="{{ route('do_login') }}" method="post">
          {{ csrf_field() }}

          <!-- Display Errors -->
          @if($errors->any())
            <div class="form-group">
              @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                  <strong>Error!</strong> {{ $error }}
                </div>
              @endforeach
            </div>
          @endif

          <!-- Email Input -->
          <div class="form-group mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" class="form-control" placeholder="Enter your email" name="email" required>
          </div>

          <!-- Password Input -->
          <div class="form-group mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password" required>
          </div>

          <!-- Login Button -->
          <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </div>

          <!-- Social Login Buttons -->
          <div class="form-group text-center">
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

          <!-- Forgot Password Link -->
          @if (Route::has('password.request'))
            <div class="form-group mt-3 text-center">
              <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                Forgot your password?
              </a>
            </div>
          @endif

        </form>
      </div>
    </div>
  </div>
@endsection
