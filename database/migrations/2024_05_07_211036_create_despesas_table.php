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
        Schema::create('despesas', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->text('descricao');
            $table->decimal('valor_unidade', 10, 2);
            $table->unsignedInteger('quantidade');
            $table->decimal('valor_total',10,2);
            $table->decimal('valor_pago', 10, 2);
            $table->boolean('pago');

            $table->foreignUuid('categoria_despesa_id')
                ->constrained('categoria_despesas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignUuid('evento_id')
                ->constrained('eventos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
