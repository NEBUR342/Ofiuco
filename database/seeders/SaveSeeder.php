<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\Save;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publicaciones = Publication::all();
        foreach ($publicaciones as $publicacion) {
            if ($publicacion->comunidad == 'SI') {
                $comunidad = $publicacion->community;
                $usuarios = $comunidad->users;
                foreach ($usuarios as $usuario) {
                    if (random_int(0, 1)) {
                        Save::create([
                            'publication_id' => $publicacion->id,
                            'user_id' => $usuario->id
                        ]);
                    }
                }
            } else {
                $usuarios = User::all();
                foreach($usuarios as $usuario){
                    if (random_int(0, 1)) {
                        Save::create([
                            'publication_id' => $publicacion->id,
                            'user_id' => $usuario->id
                        ]);
                    }
                }
            }
        }
    }
}
