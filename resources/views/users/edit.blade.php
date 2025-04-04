@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#clean_permissions").click(function(){
    $('#permissions').val([]);
  });
  $("#clean_roles").click(function(){
    $('#roles').val([]);
  });
});
</script>

<div class="d-flex justify-content-center">
    <div class="row m-4 col-sm-8">
        <form action="{{ route('users_save', $user->id) }}" method="post">
            {{ csrf_field() }}
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                <strong>Error!</strong> {{$error}}
            </div>
            @endforeach

            <div class="row mb-2">
                <div class="col-12">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" required value="{{ $user->name }}">
                </div>
            </div>

            @can('admin_users')
            <div class="col-12 mb-2">
                <label for="roles" class="form-label">Roles:</label> (<a href="#" id="clean_roles">reset</a>)
                <select multiple class="form-select" id="roles" name="roles[]">
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $role->taken ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 mb-2">
                <label for="permissions" class="form-label">Direct Permissions:</label> (<a href="#" id="clean_permissions">reset</a>)
                <select multiple class="form-select" id="permissions" name="permissions[]">
                    @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}" {{ $permission->taken ? 'selected' : '' }}>
                        {{ $permission->display_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endcan

            {{-- Allow admins and employees to update credit --}}
            @if(auth()->user()->hasAnyRole(['admin', 'employee']) && $user->hasRole('customer'))
            <div class="col-12 mb-2">
                <label for="credit" class="form-label">Account Credit:</label>
                <input type="number" class="form-control" name="credit" value="{{ $user->credit }}" required min="0">
            </div>
            @endif

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
