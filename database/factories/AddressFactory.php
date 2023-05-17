<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'addressable_id' => Customer::factory(),
            'addressable_type' => fn (array $attributes) => Customer::find($attributes['addressable_id'])->getMorphClass(),
            'line_1' => fake()->streetAddress,
            'line_2' => null,
            'city' => fake()->city,
            'county' => fake()->county,
            'postcode' => fake()->postcode,
        ];
    }

    public function of(Factory|Model $owner)
    {
        return $this->for($owner, 'addressable');
    }
}
