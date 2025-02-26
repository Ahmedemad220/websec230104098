@extends('layouts.master')
@section('title', 'Welcome')
@section('content')
    <body>

        <div class="container mt-4">
            <h2 class="text-center mb-4">Supermarket Bill</h2>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price (per unit)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalBill = 0; @endphp
                    @foreach ($bill as $item)
                        @php $itemTotal = $item['quantity'] * $item['price']; @endphp
                        <tr>
                            <td>{{ $item['item'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>${{ number_format($itemTotal, 2) }}</td>
                        </tr>
                        @php $totalBill += $itemTotal; @endphp
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                        <td><strong>${{ number_format($totalBill, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>

        </div>

    </body>

@endsection