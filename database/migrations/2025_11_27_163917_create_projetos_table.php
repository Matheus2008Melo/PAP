<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('disciplina_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('descricao');
            $table->string('descricao_curta', 300)->nullable();
            $table->string('ano_letivo');
            $table->string('url_externa')->nullable();
            $table->json('metadados')->nullable();
            $table->enum('status', ['rascunho', 'pendente', 'aprovado', 'rejeitado'])->default('pendente');
            $table->string('featured_image')->nullable();
            $table->integer('visitas')->default(0);
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->integer('vote_score')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            
            $table->index('status');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};