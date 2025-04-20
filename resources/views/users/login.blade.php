@extends('layouts.master')

@section('title', 'Login')

@section('content')
  <div class="d-flex justify-content-center">
    <div class="card m-4 col-sm-6">
      <div class="card-body">
        <form action="{{ route('do_login') }}" method="post">
          {{ csrf_field() }}

          <div class="form-group">
            @foreach($errors->all() as $error)
              <div class="alert alert-danger">
                <strong>Error!</strong> {{$error}}
              </div>
            @endforeach
          </div>

          <div class="form-group mb-2">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
          </div>

          <div class="form-group mb-2">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
          </div>

          <div class="form-group mb-2">
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="{{ route('google.login') }}" class="btn btn-danger">Login with Google</a>
          </div>

          <!-- Forgot Password Link -->
          @if (Route::has('password.request'))
            <div class="form-group mt-2 text-center">
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
