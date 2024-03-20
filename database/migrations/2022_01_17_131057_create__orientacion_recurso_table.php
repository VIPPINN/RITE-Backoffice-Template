<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrientacionRecursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orientado_recursos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('recursoId');
            $table->unsignedBigInteger('orientadoId');

            $table->foreign('recursoId')
            ->references('id')
            ->on('recursos')
            ->onDelete('no action');

            $table->foreign('orientadoId')
            ->references('id')
            ->on('orientadoRecurso')
            ->onDelete('no action');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orientado_recurso');
    }
}
