<?php

use App\Http\Resources\ReviewResource;
use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn () => inertia('Landing', [
    'reviews' => ReviewResource::collection(
        Review::with(['reviewer', 'reviewable.author'])
            ->whereMorphedTo('reviewer', User::class)
            ->whereMorphRelation('reviewable', Book::class, 'is_featured', true)
            ->groupBy('id')
            ->groupBy('reviewable_id')
            ->latest()
            ->limit(4)
            ->get()
    )
]));

Route::get('/book', fn () => Book::first());
