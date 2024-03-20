<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->longText('descripcion');
            $table->string('descargaLink');
            $table->boolean('status')->default(0);

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('idTipoRecurso');
            
            
            $table->unsignedBigInteger('idOrigenRecurso');

            $table->unsignedBigInteger('idTemaRecurso');

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->foreign('idTipoRecurso')
            ->references('id')
            ->on('tipoRecurso')
            ->onDelete('no action');

           

            $table->foreign('idOrigenRecurso')
            ->references('id')
            ->on('origenRecurso')
            ->onDelete('no action');

            $table->foreign('idTemaRecurso')
            ->references('id')
            ->on('temaRecurso')
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
        Schema::dropIfExists('recurso');
    }
}
