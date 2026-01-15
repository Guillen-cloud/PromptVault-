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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('prompt_id')->nullable()->constrained('prompts')->onDelete('set null');
            $table->string('accion', 40);
            $table->text('descripcion');
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id', 'idx_actividades_user');
            $table->index('accion', 'idx_actividades_accion');
            $table->index('created_at', 'idx_actividades_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
