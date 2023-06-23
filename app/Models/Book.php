<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Book extends Model
{
    use HasFactory;

    protected $with = [
        'genre',
        'subgenre',
    ];

    protected $casts = [
        'is_featured' => 'bool',
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function subgenre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function recordings(): HasMany
    {
        return $this->hasMany(Recording::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function allLoans(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class)
            ->using(Loan::class)
            ->withPivot(['due_back_at', 'returned_at'])
            ->withTimestamps();
    }

    public function currentLoans(): BelongsToMany
    {
        return $this->allLoans()->wherePivotNull('returned_at');
    }
}
