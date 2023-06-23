<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends Model
{
    use HasFactory;

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewer');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function allLoans(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)
            ->using(Loan::class)
            ->withPivot(['due_back_at', 'returned_at'])
            ->withTimestamps();
    }

    public function currentLoans(): BelongsToMany
    {
        return $this->allLoans()->wherePivotNull('returned_at');
    }
}
