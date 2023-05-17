<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Customer;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'user' => User::class,
            'customer' => Customer::class,
            'publisher' => Publisher::class,
            'book' => Book::class,
            'author' => Author::class,
        ]);
    }
}
