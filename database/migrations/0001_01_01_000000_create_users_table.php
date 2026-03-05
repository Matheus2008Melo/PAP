<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->rememberToken();  // cria varchar(100) nullable
            $table->timestamps();     // created_at & updated_at
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('titulo', 255);
            $table->string('slug', 255)->unique();
            $table->text('conteudo');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->string('url', 255);
            $table->boolean('is_cover')->default(false);
            $table->string('legenda', 255)->nullable();
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('imagens');
    }
};
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->timestamps();
 
            $table->unique(['user_id', 'post_id']);
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comentarios')->onDelete('cascade');
            $table->text('conteudo');
            $table->timestamps();
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};