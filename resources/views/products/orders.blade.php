@extends('layouts.master')
@section('title', 'Orders')
@section('content')
<div class="container mt-4">
    <h3>My Orders</h3>

    @if ($orders->isEmpty())
        <div class="alert alert-info">You have not purchased any products yet.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->product->name ?? 'N/A' }}</td>
                        <td>{{ $order->price }}</td>
                        <td>{{ $order->status }}</td> 
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</div>
@endsection
