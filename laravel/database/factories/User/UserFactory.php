<?php

namespace Database\Factories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password = '123123';

    protected $model = User::class;

    protected $genders = ['мужчина', 'женщина'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $gender = fake()->randomElement($this->genders);

        $gender = ($gender == 'мужчина') ? 'male' : 'female';

        return [
            'username' => fake()->userName(),
            'gender' => $gender,
            'firstname' => fake()->firstName($gender),
            'lastname' => fake()->lastName($gender),
            'fathername' => fake()->middleName($gender),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
