<?php
namespace Database\Seeders;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Database\Seeder;
class FollowSeeder extends Seeder {
    public function run(): void {
        $usuarios = User::all();
        foreach ($usuarios as $seguidor) {
            foreach ($usuarios as $user) {
                if ($seguidor->id != $user->id && random_int(0, 1)) {
                    if ($user->privado) Follow::create([
                        'user_id' => $user->id,
                        'seguidor_id' => $seguidor->id,
                        'aceptado' => 'NO'
                    ]);
                    else Follow::create([
                        'user_id' => $user->id,
                        'seguidor_id' => $seguidor->id,
                        'aceptado' => 'SI'
                    ]);
                }
            }
        }
    }
}
