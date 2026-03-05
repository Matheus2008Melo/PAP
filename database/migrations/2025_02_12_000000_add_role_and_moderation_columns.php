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
        Schema::table('users', function (Blueprint $table) {
            // Add role column after email, default to 'student'
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'student', 'teacher'])->default('student')->after('email');
            }
            
            // Add avatar column if missing
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('role');
            }
            
            // Add curso column if missing
            if (!Schema::hasColumn('users', 'curso')) {
                $table->string('curso')->nullable()->after('avatar');
            }
            
            // Add ano_escolar if missing
            if (!Schema::hasColumn('users', 'ano_escolar')) {
                $table->integer('ano_escolar')->nullable()->after('curso');
            }
            
            // Add is_active if missing
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('ano_escolar');
            }
        });

        if (Schema::hasTable('posts')) {
            Schema::table('posts', function (Blueprint $table) {
                // Add approved status for moderation
                if (!Schema::hasColumn('posts', 'status')) {
                    $table->enum('status', ['aprovado', 'pendente', 'rejeitado'])->default('pendente')->after('conteudo');
                }
                
                if (!Schema::hasColumn('posts', 'rejection_reason')) {
                    $table->text('rejection_reason')->nullable()->after('status');
                }
                
                if (!Schema::hasColumn('posts', 'is_featured')) {
                    $table->boolean('is_featured')->default(false)->after('rejection_reason');
                }
                
                if (!Schema::hasColumn('posts', 'vote_score')) {
                    $table->integer('vote_score')->default(0)->after('is_featured');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'curso', 'ano_escolar', 'is_active']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['status', 'rejection_reason', 'is_featured', 'vote_score']);
        });
    }
};
