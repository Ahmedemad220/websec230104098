@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Book List</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
    <table class="table mt-3">
        <tr>
            <th>Title</th><th>Author</th><th>Published Year</th>
        </tr>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->published_year }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection

<?php
// resources/views/books/create.blade.php
?>
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Add Book</h2>
    <form method="POST" action="{{ route('books.store') }}">
        @csrf
        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Author:</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Published Year:</label>
            <input type="number" name="published_year" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
