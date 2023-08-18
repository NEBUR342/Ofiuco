<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new \Mmo\Faker\PicsumProvider($this->faker));
        return [
            'nombre'=>ucfirst($this->faker->unique()->words(random_int(2,4), true)),
            'descripcion'=>$this->faker->text(),
            'imagen'=>'imagenesComunidad/'.$this->faker->picsum($dir = 'public/storage/imagenesComunidad/', $width = 640, $height = 480, $fullPath = false),
            'user_id'=>User::all()->random()->id,
        ];
    }
}
