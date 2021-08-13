<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distritos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->char('id', 6)->primary();
            $table->char('departamento_id', 2);
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
            $table->string('departamento');
            $table->char('provincia_id', 4);
            $table->foreign('provincia_id')->references('id')->on('provincias')->onDelete('cascade');
            $table->string('provincia');
            $table->string('nombre');
            $table->string('nombre_legal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distritos');
    }
}
