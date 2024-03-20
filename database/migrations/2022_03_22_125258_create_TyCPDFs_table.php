<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTyCPDFsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tycpdfs', function (Blueprint $table) {
            $table->id();
            $table->string('pdfNombre');           
            $table->integer('idTyC');          
            $table->date('fechaAlta');
            $table->date('fechaBaja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
