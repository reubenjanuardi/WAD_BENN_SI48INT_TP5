use App\Http\Controllers\BookController;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('books', BookController::class);

    Route::put('/books/{id}/borrow-return', 
        [BookController::class, 'borrowReturn']
    );

});
