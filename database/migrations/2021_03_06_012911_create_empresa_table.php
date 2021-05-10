<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('ruc');
            $table->string('razon_social');
            $table->string('nombre_comercial');
            $table->mediumText('direccion_fiscal');
            $table->string('direccion');

            $table->string('ruta_logo')->nullable();
            $table->string('nombre_logo')->nullable();
            $table->longText('base64_logo')->nullable();

            $table->string('ruta_logo_icon')->nullable();
            $table->string('nombre_logo_icon')->nullable();
            $table->longText('base64_logo_icon')->nullable();


            $table->string('ruta_logo_large')->nullable();
            $table->string('nombre_logo_large')->nullable();
            $table->longText('base64_logo_large')->nullable();
            
           
            $table->string('telefono_movil');
            $table->string('contraseña');
            $table->string('correo_electronico'); 
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('color')->nullable();
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
        Schema::dropIfExists('empresa');
    }
}
