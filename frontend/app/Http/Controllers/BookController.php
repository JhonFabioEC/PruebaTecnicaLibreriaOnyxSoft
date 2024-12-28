<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');

        $response = Http::get($url . '/v1/books');
        if ($response->failed()) {
            return view('book.ManagementBooksView', ['books' => []]);
        }
        $books = $response->json();

        return view('book.ManagementBooksView', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.CreateBook', ['book' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'title' => 'required',
            'author'  => 'required',
            'publication_year'  => 'required|numeric|digits:4',
            'genre'  => 'required',
        ]);

        $response = Http::post($url . '/v1/books', [
            'title' => $request->title,
            'author' => $request->author,
            'publication_year' => $request->publication_year,
            'genre' => $request->genre
        ]);

        if ($response->successful()) {
            return redirect()->route('index')->with(['success' => 'libro creado']);
        } else {
            return redirect()->route('index')->withErrors(['error' => 'no se pudo crear el libro']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::get($url . '/v1/books/' . $id);
        $book = $response->json()["book"];

        return view('book.EditBook', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'title' => 'required',
            'author'  => 'required',
            'publication_year'  => 'required|numeric|digits:4',
            'genre'  => 'required',
        ]);

        $response = Http::put($url . '/v1/books/' . $id, [
            'title' => $request->title,
            'author' => $request->author,
            'publication_year' => $request->publication_year,
            'genre' => $request->genre
        ]);

        if ($response->successful()) {
            return redirect()->route('index')->with(['success' => 'libro actualizado']);
        } else {
            return redirect()->route('index')->withErrors(['error' => 'no se pudo actualizar el libro']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::delete($url . '/v1/books/' . $id);

        if ($response->successful()) {
            return redirect()->route('index')->with(['success' => 'libro eliminado']);
        } else {
            return redirect()->route('index')->withErrors(['error' => 'no se pudo eliminar el libro']);
        }
    }
}
