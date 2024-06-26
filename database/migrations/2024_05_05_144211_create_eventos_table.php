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
        Schema::create('eventos', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('nome')->unique();
            $table->text('descricao')->nullable();
            $table->dateTime('data_inicio');
            $table->dateTime('data_fim')->nullable();

            $table->text('modalidade');

            $table->text('endereco')->nullable();
            $table->text('cidade')->nullable();
            $table->text('cep')->nullable();
            $table->text('estado')->nullable();


            $table->text('link')->nullable();
            $table->text('imagem')->nullable();

            $table->foreignUuid('categoria_evento_id')
                ->constrained('categoria_eventos')
                ->cascadeOnUpdate()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
