<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'genre' => $this->genre->name,
            'subgenre' => $this->subgenre?->name,
            'author' => AuthorResource::make($this->author),
            'title' => $this->title,
            'blurb' => $this->blurb,
            'cover' => $this->cover,
        ];
    }
}
