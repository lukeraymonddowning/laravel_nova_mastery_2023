<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

class Review extends Model
{
    use HasFactory;
    use Searchable;

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    protected function makeAllSearchableUsing(EloquentBuilder $query)
    {
        return $query->with('reviewable');
    }

    public function reviewer(): MorphTo
    {
        return $this->morphTo();
    }

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }
}
