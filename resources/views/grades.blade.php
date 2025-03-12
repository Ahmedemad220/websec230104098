@extends('layouts.master')

@section('title', 'Grades')

@section('content')
<div class="container">
    <h2>Grades by Term</h2>
    <a href="{{ route('grades.create') }}" class="btn btn-primary mb-3">Add Grade</a>

    @foreach($grades as $term => $termGrades)
        <h3>Term {{ $term }}</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Code</th>
                    <th>Credit Hours</th>
                    <th>Grade</th>
                    <th>GPA</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $totalCH = 0; $totalGP = 0; @endphp
                @foreach($termGrades as $grade)
                    @php
                        $totalCH += $grade->credit_hours;
                        $totalGP += $grade->credit_hours * $grade->grade_point;
                    @endphp
                    <tr>
                        <td>{{ $grade->course_name }}</td>
                        <td>{{ $grade->course_code }}</td>
                        <td>{{ $grade->credit_hours }}</td>
                        <td>{{ $grade->letter_grade }}</td>
                        <td>{{ $grade->grade_point }}</td>
                        <td>
                            <a href="{{ route('grades.edit', $grade->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('grades.destroy', $grade->id) }}" method="post" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"><strong>Total Credit Hours:</strong> {{ $totalCH }}</td>
                    <td colspan="2"><strong>GPA:</strong> {{ number_format($totalGP / $totalCH, 2) }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach
</div>
@endsection
