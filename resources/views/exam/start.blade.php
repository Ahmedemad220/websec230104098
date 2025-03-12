@extends('layouts.master')
@section('content')
    <h2>Start Exam</h2>
    <form action="{{ route('exam.submit') }}" method="POST">
        @csrf
        @foreach($questions as $question)
            <div class="card mb-3">
                <div class="card-body">
                    <p>{{ $question->question }}</p>
                    <label><input type="radio" name="answers[{{ $question->id }}]" value="{{ $question->option_a }}"> {{ $question->option_a }}</label><br>
                    <label><input type="radio" name="answers[{{ $question->id }}]" value="{{ $question->option_b }}"> {{ $question->option_b }}</label><br>
                    <label><input type="radio" name="answers[{{ $question->id }}]" value="{{ $question->option_c }}"> {{ $question->option_c }}</label><br>
                    <label><input type="radio" name="answers[{{ $question->id }}]" value="{{ $question->option_d }}"> {{ $question->option_d }}</label><br>
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit Exam</button>
    </form>
@endsection
