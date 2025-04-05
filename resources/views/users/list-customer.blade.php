@extends('layouts.master')

@section('title', 'List Customers')

@section('content')
<div class="container">
    <h1>List of Customers</h1>

    {{-- Display success message if available --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Display error message if available --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Current Credit</th>
                <th>Charge Credit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->credit }}</td>
                    <td>
                        <form action="{{ route('customers.charge-credit', $customer->id) }}" method="POST">
                            @csrf
                            <input type="number" name="credit" min="0.01" step="0.01" required>
                            <button type="submit" class="btn btn-primary">Charge</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
