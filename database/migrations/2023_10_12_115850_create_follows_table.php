<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('seguidor_id');
            $table->unsignedBigInteger('seguido_id');
            $table->foreign('seguidor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seguido_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum("aceptado", ["SI", "NO"]);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('follows');
    }
};
