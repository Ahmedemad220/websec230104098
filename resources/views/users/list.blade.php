@extends('layouts.master')
@section('title', 'Users')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Users</h1>
    </div>
</div>
<form>
    <div class="row">
        <div class="col col-sm-2">
            <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col col-sm-1">
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>
</form>

<div class="card mt-2">
  <div class="card-body">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Roles</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td scope="col">{{$user->id}}</td>
          <td scope="col">{{$user->name}}</td>
          <td scope="col">{{$user->email}}</td>
          <td scope="col">
            @foreach($user->roles as $role)
              <span class="badge bg-primary">{{$role->name}}</span>
            @endforeach
          </td>
          <td scope="col">
            @can('edit_users')
            <a class="btn btn-primary" href="{{ route('users_edit', $user->id) }}">Edit</a>
            @endcan
            @can('admin_users')
            <a class="btn btn-primary" href="{{ route('edit_password', $user->id) }}">Change Password</a>
            @endcan
            @can('delete_users')
            <form action="{{ route('users_delete', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            @endcan
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
