<?php
namespace Database\Seeders;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
class DatabaseSeeder extends Seeder {
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(TagSeeder::class);
        Storage::deleteDirectory('imagenesComunidad');
        Storage::createDirectory('imagenesComunidad');
        Storage::deleteDirectory('imagenesPublicacion');
        Storage::createDirectory('imagenesPublicacion');
        $this->call(CommunitySeeder::class);
        $this->call(PublicationSeeder::class);
        Comment::factory(500)->create();
        $this->call(FollowSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(SaveSeeder::class);
    }
}
