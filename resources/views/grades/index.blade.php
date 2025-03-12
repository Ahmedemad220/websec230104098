@extends('layouts.master')
@section('content')
    <h2>Grades List</h2>
    <a href="{{ route('grades.create') }}" class="btn btn-success">Add Grade</a>
    @foreach($termData as $term => $data)
        <h3>Term: {{ $term }}</h3>
        <table class="table">
            <tr>
                <th>Course</th><th>Code</th><th>CH</th><th>Letter Grade</th><th>Grade Point</th><th>Actions</th>
            </tr>
            @foreach($data['grades'] as $grade)
                <tr>
                    <td>{{ $grade->course_name }}</td>
                    <td>{{ $grade->course_code }}</td>
                    <td>{{ $grade->credit_hours }}</td>
                    <td>{{ $grade->letter_grade }}</td>
                    <td>{{ $grade->grade_point }}</td>
                    <td>
                        <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        <p><strong>Total Credit Hours:</strong> {{ $data['totalCH'] }}</p>
        <p><strong>GPA:</strong> {{ $data['gpa'] }}</p>
    @endforeach
    <hr>
    <p><strong>Cumulative Credit Hours (CCH):</strong> {{ $totalCreditHours }}</p>
    <p><strong>Cumulative GPA (CGPA):</strong> {{ $cgpa }}</p>
@endsection
