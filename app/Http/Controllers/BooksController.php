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
    }

    /**
     * ==========2===========
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * =========3===========
     * Display the specified book.
     */
    public function show(string $id)
    {

    }

    /**
     * =========4===========
     * Function used to update the data of certain book
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * =========5===========
     * Remove the specified book from storage.
     */
    public function destroy(string $id)
    {
    }

    /**
     * =========6===========
     * change the availability status of a book (change is_available field)
     */
    public function borrowReturn(string $id)
    {

    }
}
