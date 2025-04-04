@extends('layouts.master')
@section('title', $product->id ? 'Edit Product' : 'Add Product')
@section('content')

<form action="{{ route('products_save', ['product' => $product->id ?? null]) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}

    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        <strong>Error!</strong> {{ $error }}
    </div>
    @endforeach

    <div class="row mb-2">
        <div class="col-6">
            <label for="code" class="form-label">Code:</label>
            <input type="text" class="form-control" name="code" placeholder="Code" required value="{{ old('code', $product->code) }}">
        </div>
        <div class="col-6">
            <label for="model" class="form-label">Model:</label>
            <input type="text" class="form-control" name="model" placeholder="Model" required value="{{ old('model', $product->model) }}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" placeholder="Name" required value="{{ old('name', $product->name) }}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label for="price" class="form-label">Price:</label>
            <input type="number" class="form-control" name="price" placeholder="Price" required step="0.01" value="{{ old('price', $product->price) }}">
        </div>
        <div class="col-6">
            <label for="stock" class="form-label">Stock Quantity:</label>
            <input type="number" class="form-control" name="stock" placeholder="Stock" required min="0" value="{{ old('stock', $product->stock) }}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" name="description" placeholder="Description" required>{{ old('description', $product->description) }}</textarea>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col">
            <label for="photo" class="form-label">Photo:</label>
            <input type="file" class="form-control" name="photo" accept="image/*">
            @if($product->photo)
                <img src="{{ asset('storage/' . $product->photo) }}" alt="Product Image" class="img-thumbnail mt-2" width="150">
            @endif
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
