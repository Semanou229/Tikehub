<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = \App\Models\Event::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);
        return [
            'organizer_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'subdomain' => 'ev-' . Str::slug($title),
            'description' => fake()->paragraph(5),
            'category' => fake()->randomElement(['Concert', 'Sport', 'Culture', 'Business', 'Autre']),
            'type' => fake()->randomElement(['concert', 'competition', 'fundraising', 'contest', 'other']),
            'start_date' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'end_date' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['start_date'], '+1 day');
            },
            'venue_name' => fake()->company(),
            'venue_address' => fake()->address(),
            'venue_city' => fake()->city(),
            'venue_country' => fake()->country(),
            'is_published' => fake()->boolean(70),
            'is_free' => fake()->boolean(20),
            'status' => fake()->randomElement(['draft', 'published', 'cancelled', 'completed']),
        ];
    }
}


