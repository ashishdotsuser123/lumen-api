<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        $genders = ['male', 'female'];
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => app('hash')->make('123456'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'mobile_number' => $this->faker->numerify('##########'),
            'gender' => $genders[rand(0,1)],
            'birthday' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'status' => rand(0,1),
            'remember_token' => Str::random(10)
        ];
    }
}
