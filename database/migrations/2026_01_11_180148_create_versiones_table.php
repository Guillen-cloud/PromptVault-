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
        Schema::create('versiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prompt_id')->constrained('prompts')->onDelete('cascade');
            $table->unsignedInteger('numero_version');
            $table->longText('contenido_anterior');
            $table->string('motivo_cambio', 255);
            $table->timestamp('created_at')->useCurrent();

            $table->index('prompt_id', 'idx_versiones_prompt');
            $table->unique(['prompt_id', 'numero_version'], 'uk_version_prompt_num');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versiones');
    }
};
