@extends('layouts.master')

@section('content')
    <h2>Edit Question</h2>
    <form action="{{ route('questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Question:</label>
        <input type="text" name="question" value="{{ $question->question }}" required>

        <label>Option A:</label>
        <input type="text" name="option_a" value="{{ $question->option_a }}" required>

        <label>Option B:</label>
        <input type="text" name="option_b" value="{{ $question->option_b }}" required>

        <label>Option C:</label>
        <input type="text" name="option_c" value="{{ $question->option_c }}" required>

        <label>Option D:</label>
        <input type="text" name="option_d" value="{{ $question->option_d }}" required>

        <label>Correct Answer:</label>
        <select name="correct_answer" required>
            <option value="option_a" {{ $question->correct_answer == 'option_a' ? 'selected' : '' }}>Option A</option>
            <option value="option_b" {{ $question->correct_answer == 'option_b' ? 'selected' : '' }}>Option B</option>
            <option value="option_c" {{ $question->correct_answer == 'option_c' ? 'selected' : '' }}>Option C</option>
            <option value="option_d" {{ $question->correct_answer == 'option_d' ? 'selected' : '' }}>Option D</option>
        </select>

        <button type="submit">Update Question</button>
    </form>
@endsection
