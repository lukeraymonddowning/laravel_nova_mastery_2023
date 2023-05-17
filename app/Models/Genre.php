<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Genre extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'parent_id');
    }
}
