<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            User::COLUMN_NAME => $this->faker->firstName.' '.$this->faker->lastName,
            User::COLUMN_EMAIL => $this->faker->unique()->safeEmail,
            User::COLUMN_EMAIL_VERIFIED_AT => now(),
            User::COLUMN_PASSWORD => Hash::make('password'),
            User::COLUMN_REMEMBER_TOKEN => Str::random(10),
        ];
    }
}
