<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
        $table->id();
	    $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
	    $table->longText('informacion');
	    $table->string('extra');
	    $table->string('read_user');
	    $table->time('creado');
        $table->timestamps();
        $table->string('extra_cadena');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
}
