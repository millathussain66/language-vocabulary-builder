<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('word_id')->constrained()->onDelete('cascade');
            $table->integer('times_seen')->default(0);
            $table->integer('times_correct')->default(0);
            $table->integer('times_incorrect')->default(0);
            $table->boolean('mastered')->default(false);
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'word_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};