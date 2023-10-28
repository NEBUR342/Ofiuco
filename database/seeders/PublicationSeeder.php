<?php
namespace Database\Seeders;
use App\Models\Publication;
use App\Models\Tag;
use Illuminate\Database\Seeder;
class PublicationSeeder extends Seeder {
    public function run(): void {
        Publication::factory(200)->create();
        $publicaciones = Publication::all();
        $tags = Tag::all()->pluck('id')->toArray();
        foreach ($publicaciones as $publicacion) {
            unset($mistags);
            $mistags = [];
            for ($i = 0; $i < random_int(1, 3); $i++) {
                do {
                    $provisional = random_int(1, count($tags));
                } while (in_array($provisional, $mistags));
                $mistags[$i] = $provisional;
            }
            $publicacion->tags()->attach($mistags);
        }
    }
}
