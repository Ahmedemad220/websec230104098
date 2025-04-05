@extends('layouts.master')
@section('title', 'Welcome')
@section('content')
    <div class="card m-4 col-sm-5" >
        <div class="card-header">Even Numbers</div>
        <div class="card-body">
            <table>
            @foreach (range(1, 100) as $i)
                @if($i%2==0)
                    <span class="badge bg-primary">{{$i}}</span>
                @else
                    <span class="badge bg-secondary">{{$i}}</span>
                @endif
            @endforeach
            </table>
        </div>
    </div>
@endsection


