<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('frienduno_id');
            $table->unsignedBigInteger('frienddos_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('frienduno_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('frienddos_id')->references('id')->on('users')->onDelete('cascade');
            // Asegura que la combinación (frienduno_id, frienddos_id) sea única
            $table->unique(['frienduno_id', 'frienddos_id']);
            $table->enum("aceptado", ["SI", "NO"]);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('friends');
    }
};
