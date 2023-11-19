<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('destinatario_id')->nullable();
            $table->foreign('destinatario_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('community_id')->nullable();
            $table->text('contenido');
            $table->string('leido')->default(',');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('chats');
    }
};