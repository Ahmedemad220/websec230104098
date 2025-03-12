@extends('layouts.master')

@section('title', 'Edit Product')

@section('content')
<form action="{{ $product->id ? route('products_save', $product->id) : route('products_save') }}" 
      method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    @if($product->id)
        @method('PATCH')
    @endif

    <div class="row mb-2">
        <div class="col-6">
            <label for="code" class="form-label">Code:</label>
            <input type="text" class="form-control" name="code" required value="{{ old('code', $product->code) }}">
        </div>
        <div class="col-6">
            <label for="model" class="form-label">Model:</label>
            <input type="text" class="form-control" name="model" required value="{{ old('model', $product->model) }}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" required value="{{ old('name', $product->name) }}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label for="price" class="form-label">Price:</label>
            <input type="number" class="form-control" name="price" required value="{{ old('price', $product->price) }}">
        </div>
        <div class="col-6">
            <label for="photo" class="form-label">Photo:</label>
            <input type="file" class="form-control" name="photo">
            @if($product->photo)
                <br>
                <img src="{{ asset('images/' . $product->photo) }}" width="100" alt="Product Image">
            @endif
        </div>
    </div>

    <div class="row mb-2">
        <div class="col">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" name="description" required>{{ old('description', $product->description) }}</textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
