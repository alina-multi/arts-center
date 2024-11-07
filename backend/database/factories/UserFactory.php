<?php

namespace Database\Factories;

use App\Enums\ImageExtentions;
use App\Enums\UserRoles;
use App\Models\Image;
use App\Models\ImageVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Clue\StreamFilter\fun;

class UserFactory extends Factory
{
    use WithFaker;

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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => Str::slug($this->faker->userName),
            'email_verified_at' => now(),
            'password' => Hash::make('paSSword1'),
            'remember_token' => Str::random(10),
            'image_id' => Image::factory(['folder' => 'photos'])->converted(),
            'country' => $this->faker->countryCode,
            'approved_at' => now(),
            'role'=> UserRoles::User
        ];
    }
}
