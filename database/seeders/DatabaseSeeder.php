<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Book;
use App\Models\Customer;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Process\Pool;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        File::deleteDirectory(public_path('storage'));
        File::ensureDirectoryExists(public_path('storage/authors'));
        File::ensureDirectoryExists(public_path('storage/covers'));

        $user = User::factory()->create([
            'name' => 'Luke Downing',
            'email' => $this->command->ask("What email address would you like to use?", "luke@laracasts.com"),
        ]);

        Publisher::factory(10)->create();

        $this->call([GenreSeeder::class, RealDataSeeder::class]);

        $authors = Author::factory(10)->create();

        $numberOfBooks = 50;

        $pool = Process::pool(function (Pool $pool) use ($numberOfBooks) {
            for ($i = 0; $i < $numberOfBooks; $i++) {
                $pool->path(base_path())->command('php artisan db:seed BookSeeder');
            }
        })->start(function (string $type, string $output, int $key) {
            $this->command->getOutput()->writeln(sprintf("Book %d output:", $key + 1));
            $this->command->getOutput()->writeln($output);
        });

        Review::factory()->for($user, 'reviewer')->forEachSequence(
            ...$authors
            ->random(4)
            ->map(fn(Author $author) => ['reviewable_id' => $author->getKey(), 'reviewable_type' => $author->getMorphClass(), 'stars' => null])
        )->create();

        $pool->wait();

        $books = Book::all();

        $customers = Customer::factory(70)
            ->hasAttached($books->random(rand(0, 8)), ['due_back_at' => fake()->dateTimeBetween('-1 month', '+2 months'), 'returned_at' => null], 'allLoans')
            ->create();

        Review::factory(20)->crossJoinSequence(
            $customers->random(10)->map(fn (Customer $customer) => ['reviewer_id' => $customer->getKey(), 'reviewer_type' => $customer->getMorphClass()]),
            $books->random(4)->map(fn (Book $book) => ['reviewable_id' => $book->getKey(), 'reviewable_type' => $book->getMorphClass()]),
        )->create(['verified_at' => null]);
    }
}
