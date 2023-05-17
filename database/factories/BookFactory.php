<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'genre_id' => Genre::factory(),
            'subgenre_id' => fn (array $attributes) => Genre::factory()->state(['parent_id' => $attributes['genre_id']]),
            'author_id' => Author::factory(),
            'publisher_id' => Publisher::factory(),
            'title' => Str::title(fake()->words(4, true)),
            'blurb' => fake()->paragraph,
            'number_of_pages' => fake()->numberBetween(100, 500),
            'number_of_copies' => fake()->numberBetween(1, 10),
            'is_featured' => false,
            'cover' => '/covers/' . fake()->image('public/storage/covers', 300, 450, null, false),
            'pdf' => null,
        ];
    }
}
