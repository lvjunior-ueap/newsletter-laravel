<?php

namespace Database\Factories;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'active' => false,
            'token' => Str::uuid(),
            'confirmed_at' => null,
        ];
    }

    /**
     * Estado confirmado
     */
    public function confirmed(): static
    {
        return $this->state(fn () => [
            'active' => true,
            'confirmed_at' => now(),
            'token' => null,
        ]);
    }
}
