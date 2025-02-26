@extends('layouts.master')
@section('title', 'Welcome')
@section('content')
     <body>
        <div class="card m-4 col-sm-5">
            <div class="card-header">Prime Numbers</div>
            <div class="card-body">
                <table>
                @foreach (range(1, 100) as $i)
                    @if(isPrime($i))
                        <span class="badge bg-primary">{{$i}}</span>  
                    @else
                        <span class="badge bg-secondary">{{$i}}</span>  
                    @endif
                @endforeach
                </table>
            </div>
        </div>
     </body>
@endsection