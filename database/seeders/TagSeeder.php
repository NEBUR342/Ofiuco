<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags=[
            'Informatica'=>"#c0392b",
            'VideoJuegos'=>"#52be80",
            'Cine'=>"#D310E7",
            'Deportes'=>"#f39c12",
            "Música"=>"#424949",
            "Viajes"=>"#437895"
        ];
        foreach($tags as $nombre => $color){
            Tag::create([
                'nombre'=>$nombre,
                'color'=>$color,
                'descripcion'=>'etiqueta creada por defecto'
            ]);
        }
    }
}
