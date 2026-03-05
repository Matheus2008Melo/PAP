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
        Schema::table('projetos', function (Blueprint $table) {
            $table->decimal('rating_average', 3, 1)->default(0)->after('visitas');
            $table->integer('rating_count')->default(0)->after('rating_average');
            
            // Removing old vote columns
            $table->dropColumn(['upvotes', 'downvotes', 'vote_score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->dropColumn(['rating_average', 'rating_count']);
            
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->integer('vote_score')->default(0);
        });
    }
};
