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
        Schema::create('inscricaos', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('evento_id')->constrained('eventos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->text('nome');
            $table->string('email');
            $table->text('cpf');

            $table->unique(['evento_id', 'email']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricaos');
    }
};
