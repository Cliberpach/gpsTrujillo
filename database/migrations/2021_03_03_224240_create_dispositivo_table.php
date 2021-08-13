<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispositivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispositivo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('nombre');
            $table->foreignId('tipodispositivo_id')
                  ->references('id')->on('tipodispositivo')
                  ->onDelete('cascade');
            $table->string('imei');
            $table->string('nrotelefono');
            $table->string('operador');
            $table->foreignId('cliente_id')
                  ->references('id')->on('clientes')
                  ->onDelete('cascade');
            $table->string('placa');
            $table->string('color');
            $table->string('modelo');
            $table->string('marca');
            $table->enum('activo',['VIGENTE','BAJA'])->default('VIGENTE');
            $table->enum('estado',['ACTIVO','ANULADO'])->default('ACTIVO');
            $table->enum('pago',['AL DIA','DEUDA','CORTE'])->default('AL DIA');
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
        Schema::dropIfExists('dispositivo');
    }
}
