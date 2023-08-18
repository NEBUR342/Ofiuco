<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new \Mmo\Faker\PicsumProvider($this->faker));
        $randomuser = User::all()->random();
        $randomcommunity = $randomuser->communities->random()->id;
        if(random_int(0,1))
        return [
            'titulo' => ucfirst($this->faker->unique()->words(random_int(2, 4), true)),
            'contenido' => $this->faker->text(),
            'estado'=>random_int(1,2),
            'comunidad'=>1,
            'imagen' => 'imagenesPublicacion/' . $this->faker->picsum($dir = 'public/storage/imagenesPublicacion', $width = 640, $height = 480, $fullPath = false),
            'user_id' => $randomuser->id,
            'community_id' => $randomcommunity,
        ];
        else
        return [
            'titulo' => ucfirst($this->faker->unique()->words(random_int(2, 4), true)),
            'contenido' => $this->faker->text(),
            'estado'=>random_int(1,2),
            'comunidad'=>2,
            'imagen' => 'imagenesPublicacion/' . $this->faker->picsum($dir = 'public/storage/imagenesPublicacion', $width = 640, $height = 480, $fullPath = false),
            'user_id' => $randomuser->id,
        ];
    }
}
