<?php

use App\Models\Author;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Genre::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Genre::class, 'subgenre_id')->nullable()->constrained('genres')->nullOnDelete();
            $table->foreignIdFor(Author::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Publisher::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('blurb');
            $table->integer('number_of_pages');
            $table->integer('number_of_copies');
            $table->boolean('is_featured');
            $table->string('purchase_url')->nullable();
            $table->string('cover');
            $table->string('pdf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
