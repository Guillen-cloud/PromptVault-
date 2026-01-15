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
        Schema::create('prompt_tag', function (Blueprint $table) {
            $table->foreignId('prompt_id')->constrained('prompts')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('etiquetas')->onDelete('cascade');
            $table->primary(['prompt_id', 'tag_id']);

            $table->index('tag_id', 'idx_prompt_tag_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompt_tag');
    }
};
