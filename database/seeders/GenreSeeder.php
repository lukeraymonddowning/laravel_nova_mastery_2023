<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
