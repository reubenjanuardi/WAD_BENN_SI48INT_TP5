<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ItemsController;

/**
 * =============================
 * Public routes (no token)
 * =============================
 */
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


/**
 * =============================
 * Protected routes (requires token)
 * =============================
 */
Route::middleware('auth:sanctum')->group(function () {

    /**
     * User logout
     */
    Route::post('logout', [AuthController::class, 'logout']);

    /**
     * Books CRUD
     */
    Route::apiResource('books', BooksController::class);

    /**
     * Borrow / Return a book
     */
    Route::put('books/{id}/borrow-return', [BooksController::class, 'borrowReturn']);

    /**
     * Categories CRUD
     */
    Route::apiResource('categories', CategoriesController::class);

    /**
     * Items CRUD (TP requirement)
     */
    Route::apiResource('items', ItemsController::class);
});
