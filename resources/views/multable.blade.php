@extends('layouts.master')
@section('title', 'Welcome')
@section('content')

    <body>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Multiplication Table (1 to 12)</h2>

        <div class="row">
            @foreach (range(1, 12) as $j)
                <div class="card m-3 col-sm-3">
                    <div class="card-header bg-primary text-white text-center">
                        {{ $j }} Multiplication Table
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            @foreach (range(1, 10) as $i)
                                <tr>
                                    <td>{{ $i }} × {{ $j }}</td>
                                    <td>=</td>
                                    <td>{{ $i * $j }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

