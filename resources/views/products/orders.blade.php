@extends('layouts.master')
@section('title', 'Orders')
@section('content')
<div class="container mt-4">
    <h3>My Orders</h3>

    @if ($orders->isEmpty())
        <div class="alert alert-info">You have not purchased any products yet.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Product</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Purchased At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->product->model }}</td>
                    <td>{{ number_format($order->price, 2) }} EGP</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
