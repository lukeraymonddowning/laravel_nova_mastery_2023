<?php

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::get('/books', function () {
    return Book::withCount(['allLoans' => fn ($query) => $query->where('book_customer.created_at', '>=', now()->subYear())])
        ->orderByDesc('all_loans_count')
        ->limit(5)
        ->get();
});
