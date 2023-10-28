<?php
namespace Database\Factories;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
class CommentFactory extends Factory {
    public function definition(): array {
        $aux = random_int(1, count(Publication::all()));
        $randompublication = Publication::find($aux);
        if ($randompublication->comunidad == 'SI') {
            $comunidad = $randompublication->community;
            $randomuser = $comunidad->users()->inRandomOrder()->first();
        } else {
            $randomuser = User::all()->random()->id;
        }
        return [
            'contenido' => $this->faker->text(),
            'user_id' => $randomuser,
            'publication_id' => $randompublication->id,
        ];
    }
}
