<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projeto_anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->constrained()->onDelete('cascade');
            $table->string('caminho_ficheiro');
            $table->string('nome_original');
            $table->string('extensao', 10)->nullable();
            $table->unsignedBigInteger('tamanho')->nullable(); // Size in bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projeto_anexos');
    }
};
