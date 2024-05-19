<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $mode = User::class;
    
    public function definition()
    {
        return [
            'remember_token' => Str::random(10),
            'username' => fake()->regexify('[a-z]{5}'),
            // 'password' => Hash::make(fake()->name()),
            'password' => fake()->regexify('[a-z]{5}'), 
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'status' => 'group',
            'file' => '/profile-images/user1.png',
            'category' => 'Informatika',
            'description' => fake()->sentence(),
        ];
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
