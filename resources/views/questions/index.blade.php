@extends('layouts.master')
@section('content')
    <h2>Questions List</h2>
    <a href="{{ route('questions.create') }}" class="btn btn-success">Add Question</a>
    <table class="table">
        <tr><th>Question</th><th>Actions</th></tr>
        @foreach($questions as $question)
            <tr>
                <td>{{ $question->question }}</td>
                <td>
                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
