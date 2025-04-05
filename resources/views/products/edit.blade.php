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
            <label for="quantity" class="form-label">Quantity:</label>
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Employee'))
                <input type="number" class="form-control" name="quantity" placeholder="Quantity" required min="0" value="{{ old('quantity', $product->quantity) }}">
            @else
                <input type="number" class="form-control" disabled value="{{ old('quantity', $product->quantity) }}">
            @endif
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
            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Employee'))
                <input type="file" class="form-control" name="photo" accept="image/*">
                @if($product->photo)
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="Product Image" class="img-thumbnail mt-2" width="150">
                @endif
            @endif
        </div>
    </div>

    @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Employee'))
        <button type="submit" class="btn btn-primary">Submit</button>
    @endif
</form>

@endsection
