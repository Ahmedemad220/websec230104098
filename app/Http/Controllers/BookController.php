<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'published_year' => 'required|digits:4|integer',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }
}
