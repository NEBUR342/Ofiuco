<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->text('descripcion');
            $table->string('imagen');
            $table->enum("privacidad", ["PUBLICO", "PRIVADO"]);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('communities');
    }
};
