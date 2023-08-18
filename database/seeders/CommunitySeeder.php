<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Community::factory(5)->create();
        $comunidades = Community::all();
        $users = User::all();
        foreach ($users as $user) {
            unset($misusuarios);
            $misusuarios = [];
            for ($i = 0; $i < random_int(1, $comunidades->count()-1); $i++) {
                do {
                    $provisional = random_int(1, $comunidades->count());
                    $creadorComunidad = Community::where('id',$provisional)->first()->user_id;
                } while (in_array($provisional, $misusuarios) || $creadorComunidad == $user->id);
                $misusuarios[$i] = $provisional;
            }
            $user->communities()->attach($misusuarios);
        }
    }
}
