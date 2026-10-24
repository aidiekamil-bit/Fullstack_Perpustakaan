<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
  public function index(Request $request)
{
    $query = Book::query();

    // Filter berdasarkan genre
    if ($request->has('genre') && !empty($request->genre)) {
        $query->where('genre', $request->genre);
    }

    // Sorting
    if ($request->has('sort')) {
        if ($request->sort === 'az') $query->orderBy('title', 'asc');
        elseif ($request->sort === 'za') $query->orderBy('title', 'desc');
        elseif ($request->sort === 'stock_high') $query->orderBy('stock', 'desc');
        elseif ($request->sort === 'stock_low') $query->orderBy('stock', 'asc');
    }

    // Ganti get() dengan paginate() dan withQueryString()
    return response()->json($query->paginate(8)->withQueryString());
}

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'genre' => 'required|string',
        'stock' => 'required|integer|min:1',
    ]);

    $book = Book::create($request->all());
    return response()->json(['message' => 'Book created successfully', 'data' => $book], 201);
}

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus'
        ]);
    }
}