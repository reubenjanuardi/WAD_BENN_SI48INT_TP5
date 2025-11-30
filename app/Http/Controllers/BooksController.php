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
            'title'=>'required|string|max:255',
            'author'=>'required|string|max:255',
            'published_year'=>'required|integer',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => 'please check your requests',
                'errors' => $validator->errors(),
            ], 422);
        }

        $book = Book::create($validator->validated());

        return(new BookResource($book))
            ->additional(['message'=> 'book created successfully'])
            ->response()
            ->setStatusCode(201);
    }   

    /**
     * =========3===========
     * Display the specified book.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        if(!$book){
            return response()->json([
                'message' => 'book not found'
            ], 404);
        }

        return new BookResource($book);
    }

    /**
     * =========4===========
     * Function used to update the data of certain book
     */
    public function update(Request $request, string $id)
    {
       $validator = Validator::make($request->all(), [
            'title'=>'required|string|max:255',
            'author'=>'required|string|max:255',
            'published_year'=>'required|integer',
        ]);

        $book = Book::find($id);

        if(!$book){
            return response()->json([
                'message' => 'book not found'
            ], 404);
        }

        if ($validator->fails()){
            return response()->json([
                'message' => 'please check your requests',
                'errors' => $validator->errors(),
            ], 422);
        }

        $book->update($validator->validated());

        return(new BookResource($book))
            ->additional(['message'=> 'book updated successfully'])
            ->response()
            ->setStatusCode(200);
       
    }

    /**
     * =========5===========
     * Remove the specified book from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        if(!$book){
            return response()->json([
                'message' => 'book not found'
            ], 404);
        }

        $book->delete();

        return response()->json([
                'message' => 'book successfuly deleted'
            ], 200);
    }

    /**
     * =========6===========
     * change the availability status of a book (change is_available field)
     */
    public function borrowReturn(string $id)
    {
         $book = Book::findOrFail($id);
         if(!$book){
            return response()->json([
                'message'=>'book not found'
            ], 400);
         }
        $book->is_available = !$book->is_available;
        $book->save();

        return response()->json([
            'message' => 'Book status updated successfully',
            'data' => $book
        ], 200);
    }
}
