<?php
namespace Database\Seeders;
use App\Models\Like;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Seeder;
class LikeSeeder extends Seeder {
    public function run(): void {
        $publicaciones = Publication::all();
        foreach ($publicaciones as $publicacion) {
            if ($publicacion->comunidad == 'SI') {
                $comunidad = $publicacion->community;
                $usuarios = $comunidad->users;
                foreach ($usuarios as $usuario) {
                    if (random_int(0, 1)) {
                        Like::create([
                            'publication_id' => $publicacion->id,
                            'user_id' => $usuario->id
                        ]);
                    }
                }
            } else {
                $usuarios = User::all();
                foreach($usuarios as $usuario){
                    if (random_int(0, 1)) {
                        Like::create([
                            'publication_id' => $publicacion->id,
                            'user_id' => $usuario->id
                        ]);
                    }
                }
            }
        }
    }
}
