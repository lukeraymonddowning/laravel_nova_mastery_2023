<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reviewer_id' => User::factory(),
            'reviewer_type' => fn (array $attributes) => User::find($attributes['reviewer_id'])->getMorphClass(),
            'reviewable_id' => Book::factory(),
            'reviewable_type' => fn (array $attributes) => Book::find($attributes['reviewable_id'])->getMorphClass(),
            'title' => fake()->sentence,
            'body' => fake()->paragraphs(5, true),
            'stars' => fake()->numberBetween(1, 5),
            'verified_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function by(Factory|Model $reviewer)
    {
        return $this->for($reviewer, 'reviewer');
    }

    public function of(Factory|Model $reviewedItem)
    {
        return $this->for($reviewedItem, 'reviewable');
    }
}
