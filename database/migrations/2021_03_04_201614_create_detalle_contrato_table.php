<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecontrato', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('contrato_id')->references('id')->on('contrato')->onDelete('cascade');
            $table->foreignId('dispositivo_id')->references('id')->on('dispositivo')->onDelete('cascade');
            $table->unsignedDecimal('pago', 15, 2);
            $table->unsignedDecimal('costo_instalacion', 15, 2);
            $table->enum('estado',['ACTIVO','ANULADO'])->default('ACTIVO');
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
        Schema::dropIfExists('detallecontrato');
    }
}
