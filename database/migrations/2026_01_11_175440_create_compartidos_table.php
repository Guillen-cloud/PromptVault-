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
        Schema::create('compartidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prompt_id')->constrained('prompts')->onDelete('cascade');
            $table->string('nombre_destinatario', 140);
            $table->string('email_destinatario', 160);
            $table->dateTime('fecha_compartido');
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index('prompt_id', 'idx_compartidos_prompt');
            $table->index('email_destinatario', 'idx_compartidos_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compartidos');
    }
};
