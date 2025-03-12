@extends('layouts.master')
@section('title', 'Welcome')
@section('content')

    <body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Student Transcript</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Course</th>
                    <th>Credit Hours</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @php $totalCredits = 0; @endphp
                @foreach ($transcript as $course)
                    @php $totalCredits += $course['credit']; @endphp
                    <tr>
                        <td>{{ $course['course'] }}</td>
                        <td>{{ $course['credit'] }}</td>
                        <td>{{ $course['grade'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td class="text-end"><strong>Total Credits:</strong></td>
                    <td colspan="2"><strong>{{ $totalCredits }}</strong></td>
                </tr>
            </tfoot>
        </table>


    </div>

    </body>
@endsection

