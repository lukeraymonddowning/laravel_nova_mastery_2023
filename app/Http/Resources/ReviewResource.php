<?php

namespace App\Http\Resources;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reviewer' => new ReviewerResource($this->reviewer),
            'reviewable_type' => $this->reviewable_type,
            'reviewable' => match ($this->reviewable::class) {
                Book::class => new BookResource($this->reviewable),
            },
            'title' => $this->title,
            'body' => $this->body,
            'stars' => $this->stars,
            'created_at' => $this->created_at,
        ];
    }
}
