<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\BookCoverController;
use App\Http\Controllers\PaperTypeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ConservationStateController;
use App\Http\Controllers\IsbnCodeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserBookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'admin',
    'prefix' => 'admin-only'
], function ($router){
    // This route can only be accessed by administrators
    
    // Tags
    Route::put('/tags/{tag}', [TagController::class, 'update']);
    Route::delete('/tags/{tag}', [TagController::class, 'delete']);
    
    // Formats
    Route::put('/formats/{format}', [FormatController::class, 'update']);
    Route::delete('/formats/{format}', [FormatController::class, 'delete']);
    
    // Book Covers
    Route::put('/book_covers/{book_cover}', [BookCoverController::class, 'update']);
    Route::delete('/book_covers/{book_cover}', [BookCoverController::class, 'delete']);
    
    // Paper Types
    Route::put('/paper_types/{paper_type}', [PaperTypeController::class, 'update']);
    Route::delete('/paper_types/{paper_type}', [PaperTypeController::class, 'delete']);
    
    // Authors
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'delete']);
    
    // Editors
    Route::put('/editors/{editor}', [EditorController::class, 'update']);
    Route::delete('/editors/{editor}', [EditorController::class, 'delete']);
    
    // Statuses
    Route::post('/statuses', [StatusController::class, 'store']);
    Route::put('/statuses/{status}', [StatusController::class, 'update']);
    Route::delete('/statuses/{status}', [StatusController::class, 'delete']);

    // Conservation States
    Route::post('/conservation_states', [ConservationStateController::class, 'store']);
    Route::put('/conservation_states/{conservation_state}', [ConservationStateController::class, 'update']);
    Route::delete('/conservation_states/{conservation_state}', [ConservationStateController::class, 'delete']);
    
    // ISBN Codes
    Route::put('/isbn_codes/{isbn_code}', [IsbnCodeController::class, 'update']);
    Route::delete('/isbn_codes/{isbn_code}', [IsbnCodeController::class, 'delete']);

    // Books
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'delete']);

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::delete('/users/{user}', [UserController::class, 'delete']);
    
});

Route::middleware('api')->group(function (){
    // Auth
    Route::post('/login', [AuthController::class, 'login']);

    // Tags
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tags/{tag}', [TagController::class, 'show']);
    
    // Formats
    Route::get('/formats', [FormatController::class, 'index']);
    Route::get('/formats/{format}', [FormatController::class, 'show']);

    // Book Covers
    Route::get('/book_covers', [BookCoverController::class, 'index']);
    Route::get('/book_covers/{book_cover}', [BookCoverController::class, 'show']);

    // Paper Types
    Route::get('/paper_types', [PaperTypeController::class, 'index']);
    Route::get('/paper_types/{paper_type}', [PaperTypeController::class, 'show']);

    // Authors
    Route::get('/authors', [AuthorController::class, 'index']);
    Route::get('/authors/{author}', [AuthorController::class, 'show']);

    // Editors
    Route::get('/editors', [EditorController::class, 'index']);
    Route::get('/editors/{editor}', [EditorController::class, 'show']);

    // Statuses
    Route::get('/statuses', [StatusController::class, 'index']);
    Route::get('/statuses/{status}', [StatusController::class, 'show']);

    // Conservation States
    Route::get('/conservation_states', [ConservationStateController::class, 'index']);
    Route::get('/conservation_states/{conservation_state}', [ConservationStateController::class, 'show']);

    // ISBN Codes
    Route::get('/isbn_codes', [IsbnCodeController::class, 'index']);
    Route::get('/isbn_codes/{isbn_code}', [IsbnCodeController::class, 'show']);


    // Books
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{book}', [BookController::class, 'show']);

    // Users
    Route::post('/users', [UserController::class, 'store']);

    // User Books
    Route::get('/user_books', [UserBookController::class, 'index']);
    Route::get('/user_books/{user_book}', [UserBookController::class, 'show']);
    Route::get('/userbooks/last', [UserBookController::class, 'showLast']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);

    // Tags
    Route::post('/tags', [TagController::class, 'store']);

    // Formats
    Route::post('/formats', [FormatController::class, 'store']);
    
    // Book Covers
    Route::post('/book_covers', [BookCoverController::class, 'store']);

    // Paper Types
    Route::post('/paper_types', [PaperTypeController::class, 'store']);

    // Authors
    Route::post('/authors', [AuthorController::class, 'store']);

    // Editors
    Route::post('/editors', [EditorController::class, 'store']);

    // Statuses
    Route::post('/isbn_codes', [IsbnCodeController::class, 'store']);

    // Books
    Route::post('/books', [BookController::class, 'store']);

    // Users
    Route::put('/users/{user}', [UserController::class, 'update']);

    //  Isbn Codes
    Route::get('/isbn_codes/search/{isbn_code}', [IsbnCodeController::class, 'search']);

    // User Books
    Route::post('/user_books', [UserBookController::class, 'store']);
    Route::put('/user_books/{user_book}', [UserBookController::class, 'update']);
    Route::delete('/user_books/{user_book}', [UserBookController::class, 'delete']);
});