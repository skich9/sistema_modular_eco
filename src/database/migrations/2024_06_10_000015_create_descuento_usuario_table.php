<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuento_usuario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('descuento_id');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('inscripcion_id')->nullable();
            $table->unsignedBigInteger('cuota_id')->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            $table->decimal('porcentaje', 5, 2)->nullable();
            $table->date('fecha_asignacion');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('descuento_id')->references('id')->on('descuentos');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('inscripcion_id')->references('id')->on('inscripciones');
            $table->foreign('cuota_id')->references('id')->on('cuotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descuento_usuario');
    }
};