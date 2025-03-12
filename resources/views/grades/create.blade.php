@extends('layouts.master')

@section('content')
    <h2>Add Grade</h2>
    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name:</label>
            <input type="text" class="form-control" name="course_name" required>
        </div>
        <div class="mb-3">
            <label for="course_code" class="form-label">Course Code:</label>
            <input type="text" class="form-control" name="course_code" required>
        </div>
        <div class="mb-3">
            <label for="credit_hours" class="form-label">Credit Hours:</label>
            <input type="number" class="form-control" name="credit_hours" required>
        </div>
        <div class="mb-3">
            <label for="grade" class="form-label">Grade:</label>
            <input type="text" class="form-control" name="grade" required>
        </div>
        <div class="mb-3">
            <label for="term" class="form-label">Term:</label>
            <input type="text" class="form-control" name="term" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
