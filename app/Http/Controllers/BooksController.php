<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Http\Resources\BookResource;

class BooksController extends Controller
{
    /**
     * ==========1===========
     * Display a listing of the books

     */
    public function index()
    {
        $books = Book::all();
        return BookResource::collection($books);
    }

    /**
     * ==========2===========
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'author' => 'required|string',
            'published_year' => 'required|integer',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'please check your request',
                'errors' => $validator->errors()
            ], 442);
        }
    }

    /**
     * =========3===========
     * Display the specified book.
     */
    public function show(string $id)
    {
        $books = Book::find($id);
        if(!$books) {
            return response()->json([
                'message' => 'Item not found'
            ], 404);
        }
        return new BookResource($books);
    }

    /**
     * =========4===========
     * Function used to update the data of certain book
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'author' => 'string',
            'published_year' => 'integer',
            'is_available' => 'boolean'
        ]);

        $books = Book::find($id);

        if ($books) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        if ($validator->fails()) {
            return response()->json([
                'message' => 'please check your request',
                'errors' => $validator->errors()
            ], 442);
        }

        $books->update($validator->validated());

        return (new BookResource($books))
                    ->additional(['message' => 'item updated successful'])
                    ->response()
                    ->setStatusCode(200);
    }

    /**
     * =========5===========
     * Remove the specified book from storage.
     */
    public function destroy(string $id)
    {
        $books = Book::find($id);

        if(!$books){
            return response()->json(['message' => 'Item not found'], 404);
        }

        $books->delete();

        return response()->json(['message' => 'item deleted successful'], 200);
    }

    /**
     * =========6===========
     * change the availability status of a book (change is_available field)
     */
    public function borrowReturn(string $id)
    {
        $books = Book::findOrFail($id);

        $books->is_available = !$books->is_available;
        $books->save();

        return new BookResource($books);
    }
}
