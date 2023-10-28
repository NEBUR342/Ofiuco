<?php
namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
class CommunityFactory extends Factory {
    public function definition(): array {
        $this->faker->addProvider(new \Mmo\Faker\PicsumProvider($this->faker));
        return [
            'nombre'=>ucfirst($this->faker->unique()->words(random_int(2,4), true)),
            'descripcion'=>$this->faker->text(),
            'imagen'=>'imagenesComunidad/'.$this->faker
            ->picsum($dir = 'public/storage/imagenesComunidad/', $width = 640, $height = 480, $fullPath = false),
            'privacidad'=>random_int(1,2),
            'user_id'=>User::all()->random()->id,
        ];
    }
}
