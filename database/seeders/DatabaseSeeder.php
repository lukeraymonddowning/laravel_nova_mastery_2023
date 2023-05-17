<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Book;
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

        $user = User::factory()->create([
            'name' => 'Luke Downing',
            'email' => $this->command->ask("What email address would you like to use?", "luke@laracasts.com"),
        ]);

        $this->buildGenres();

        Author::factory()->count(10)->create();
        Publisher::factory()->count(10)->create();

        $numberOfBooks = 50;

        $pool = Process::pool(function (Pool $pool) use ($numberOfBooks) {
            for ($i = 0; $i < $numberOfBooks; $i++) {
                $pool->path(base_path())->command('php artisan db:seed BookSeeder');
            }
        })->start(function (string $type, string $output, int $key) {
            $this->command->getOutput()->writeln(sprintf("Book %d output:", $key + 1));
            $this->command->getOutput()->writeln($output);
        });

        $pool->wait();

        $result = Review::factory()->for($user, 'reviewer')->forEachSequence(
            ...Book::inRandomOrder()
                ->limit(10)
                ->get()
                ->map(fn (Book $book) => ['reviewable_id' => $book->getKey(), 'reviewable_type' => $book->getMorphClass()])
        )->create();
    }

    /**
     * @return void
     */
    private function buildGenres(): void
    {
        [$fantasy, $horror, $mystery, $romance, $scienceFiction, $thrillerAndSuspense, $western, $biography] = Genre::factory()->forEachSequence(
            ['name' => 'Fantasy'],
            ['name' => 'Horror'],
            ['name' => 'Mystery'],
            ['name' => 'Romance'],
            ['name' => 'Science Fiction'],
            ['name' => 'Thriller and Suspense'],
            ['name' => 'Western'],
            ['name' => 'Biography'],
        )->create();

        Genre::factory()->for($fantasy, 'parent')->forEachSequence(
            ['name' => 'Alternate History'],
            ['name' => 'Children\'s Story'],
            ['name' => 'Comedy'],
            ['name' => 'Contemporary'],
            ['name' => 'Fairy Tale'],
            ['name' => 'Heroic'],
            ['name' => 'Mythic'],
            ['name' => 'Superhero'],
            ['name' => 'Urban'],
            ['name' => 'Young Adult'],
        )->create();

        Genre::factory()->for($horror, 'parent')->forEachSequence(
            ['name' => 'Gothic'],
            ['name' => 'Historical'],
            ['name' => 'Man-Made'],
            ['name' => 'Monsters'],
            ['name' => 'Psychological'],
            ['name' => 'Quiet Horror'],
        )->create();

        Genre::factory()->for($mystery, 'parent')->forEachSequence(
            ['name' => 'Amateur Sleuth'],
            ['name' => 'Bumbling Detective'],
            ['name' => 'Caper'],
            ['name' => 'Child in Peril'],
            ['name' => 'Cozy'],
            ['name' => 'Hardboiled'],
            ['name' => 'Hardboiled'],
            ['name' => 'Historical'],
            ['name' => 'Howdunit'],
            ['name' => 'Legal'],
            ['name' => 'Locked Room'],
            ['name' => 'Police Procedural'],
            ['name' => 'Private Detective'],
            ['name' => 'Whodunit'],
        )->create();

        Genre::factory()->for($romance, 'parent')->forEachSequence(
            ['name' => 'Billionaires'],
            ['name' => 'Comedy'],
            ['name' => 'Contemporary'],
            ['name' => 'Holidays'],
            ['name' => 'Inspirational'],
            ['name' => 'Military'],
            ['name' => 'Regency'],
            ['name' => 'Romantic Suspense'],
            ['name' => 'Sports'],
            ['name' => 'Time Travel'],
            ['name' => 'Young Adult'],
        )->create();

        Genre::factory()->for($scienceFiction, 'parent')->forEachSequence(
            ['name' => 'Aliens'],
            ['name' => 'Alternate History'],
            ['name' => 'Alternate/Parallel Universe'],
            ['name' => 'Apocalyptic/Post-Apocalyptic'],
            ['name' => 'Biopunk'],
            ['name' => 'Colonization'],
            ['name' => 'Cyberpunk'],
            ['name' => 'Dying Earth'],
            ['name' => 'Dystopia'],
            ['name' => 'Galactic Empire'],
            ['name' => 'Generation Ship'],
            ['name' => 'Hard Science Fiction'],
            ['name' => 'Immortality'],
            ['name' => 'Military'],
            ['name' => 'Nanopunk'],
            ['name' => 'Robots/A.I.'],
            ['name' => 'Soft Science Fiction'],
            ['name' => 'Space Exploration'],
            ['name' => 'Space Opera'],
            ['name' => 'Steampunk'],
            ['name' => 'Time Travel'],
            ['name' => 'Utopia'],
        )->create();

        Genre::factory()->for($thrillerAndSuspense, 'parent')->forEachSequence(
            ['name' => 'Action'],
            ['name' => 'Conspiracy'],
            ['name' => 'Crime'],
            ['name' => 'Disaster'],
            ['name' => 'Espionage'],
            ['name' => 'Forensic'],
            ['name' => 'Legal'],
            ['name' => 'Medical'],
            ['name' => 'Political'],
            ['name' => 'Psychological'],
            ['name' => 'Religious'],
            ['name' => 'Religious'],
        )->create();

        Genre::factory()->for($western, 'parent')->forEachSequence(
            ['name' => 'Bounty Hunters'],
            ['name' => 'Cattle Drive'],
            ['name' => 'Children\'s Story'],
            ['name' => 'Gold Rush'],
            ['name' => 'Gunfighters'],
            ['name' => 'Land Rush'],
            ['name' => 'Lawmen'],
            ['name' => 'Outlaws'],
            ['name' => 'Revenge'],
            ['name' => 'Wagon Train'],
        )->create();

        Genre::factory()->for($biography, 'parent')->forEachSequence(
            ['name' => 'Historical Fiction'],
            ['name' => 'Academic'],
            ['name' => 'Fictional Academic'],
            ['name' => 'Prophetic'],
        )->create();
    }
}
