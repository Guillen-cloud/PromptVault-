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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');
            $table->string('titulo', 180);
            $table->longText('contenido');
            $table->text('descripcion')->nullable();
            $table->string('ia_destino', 60);
            $table->boolean('es_favorito')->default(false);
            $table->boolean('es_publico')->default(false);
            $table->unsignedInteger('veces_usado')->default(0);
            $table->unsignedInteger('version_actual')->default(1);
            $table->timestamps();

            $table->index('user_id', 'idx_prompts_user');
            $table->index('categoria_id', 'idx_prompts_categoria');
            $table->index('ia_destino', 'idx_prompts_ia');
            $table->index('es_favorito', 'idx_prompts_favorito');
            $table->index('es_publico', 'idx_prompts_publico');
            $table->index('created_at', 'idx_prompts_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
