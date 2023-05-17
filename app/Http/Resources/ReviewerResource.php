<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use InvalidArgumentException;

class ReviewerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => match($this->resource::class) {
                User::class => $this->name,
                default => throw new InvalidArgumentException("Unsupported reviewer type: " . $this->resource::class),
            }
        ];
    }
}
