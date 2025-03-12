@extends('layouts.master')
@section('title', 'Product List')
@section('content')

<form>
    <div class="row">
        <div class="col-sm-2">
            <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col-sm-2">
            <input name="min_price" type="number" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}" />
        </div>
        <div class="col-sm-2">
            <input name="max_price" type="number" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}" />
        </div>
        <div class="col-sm-2">
            <select name="order_by" class="form-select">
                <option value="name">Name</option>
                <option value="price">Price</option>
            </select>
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('products_list') }}" class="btn btn-danger">Reset</a> <!-- Reset Button -->
        </div>
    </div>
</form>


<a href="{{ route('products_edit') }}" class="btn btn-success">Add Product</a>

<div class="row">
    @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mt-2">
                @if($product->photo)
                    <img src="{{ asset('images/' . $product->photo) }}" class="card-img-top" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default Image">
                @endif
                <div class="card-body">
                    <h3>{{ $product->name }}</h3>
                    <table class="table table-striped">
                        <tr><th>Model</th><td>{{ $product->model }}</td></tr>
                        <tr><th>Code</th><td>{{ $product->code }}</td></tr>
                        <tr><th>Price</th><td>${{ $product->price }}</td></tr>
                        <tr><th>Description</th><td>{{ $product->description }}</td></tr>
                    </table>
                    <a href="{{ route('products_edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('products_delete', $product->id) }}" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
