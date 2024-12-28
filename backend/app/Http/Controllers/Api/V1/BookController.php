<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();

        if ($books->isEmpty()) {
            $data = [
                'books' => [],
                'message' => 'No se encontraron libros',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($books, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'publication_year' => 'required|numeric|digits:4',
            'genre' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Datos incorrectos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publication_year' => $request->publication_year,
            'genre' => $request->genre
        ]);

        if (!$book) {
            $data = [
                'message' => 'Error al crear el libro',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'book' => $book,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            $data = [
                'message' => 'Libro no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'book' => $book,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'publication_year' => 'required|numeric|digits:4',
            'genre' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Datos incorrectos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $book->title = $request->title;
        $book->author = $request->author;
        $book->publication_year = $request->publication_year;
        $book->genre = $request->genre;

        $book->save();

        $data = [
            'message' => 'Libro actualizado',
            'book' => $book,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            $data = [
                'message' => 'Libro no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $book->delete();

        $data = [
            'message' => 'Libro eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
