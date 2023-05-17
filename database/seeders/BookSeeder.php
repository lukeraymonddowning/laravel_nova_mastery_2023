<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory()
            ->for(Author::inRandomOrder()->first())
            ->for(Publisher::inRandomOrder()->first())
            ->for(Genre::inRandomOrder()->whereDoesntHave('parent')->first())
            ->state(['subgenre_id' => fn (array $attributes) => Genre::inRandomOrder()->where('parent_id', $attributes['genre_id'])->first()->getKey()])
            ->create();
    }
}
