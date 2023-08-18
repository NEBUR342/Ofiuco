<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
        $this->call(TagSeeder::class);
        Storage::deleteDirectory('imagenesComunidad');
        Storage::createDirectory('imagenesComunidad');
        Storage::deleteDirectory('imagenesPublicacion');
        Storage::createDirectory('imagenesPublicacion');
        $this->call(CommunitySeeder::class);
        $this->call(PublicationSeeder::class);
        Comment::factory(500)->create();
        $this->call(LikeSeeder::class);
    }
}
