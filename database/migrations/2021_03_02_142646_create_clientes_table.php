<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->mediumText('nombre');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('tipo_documento');
            $table->string('documento',25);
            $table->string('nombre_comercial')->nullable();
            $table->string('direccion_fiscal');
            $table->string('direccion');
            $table->string('tipo_documento_contacto')->nullable();
            $table->string('documento_contacto')->nullable();
            $table->mediumText('nombre_contacto')->nullable();
            $table->string('telefono_movil');
            $table->string('correo_electronico');
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('activo')->default('SIN VERIFICAR');
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
        Schema::dropIfExists('clientes');
    }
}
