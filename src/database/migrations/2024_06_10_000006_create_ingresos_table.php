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
        Schema::create('ingresos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('cod_ceta')->nullable();
            $table->decimal('monto', 10, 2);
            $table->date('fecha_ingreso');
            $table->string('tipo');
            $table->text('descripcion')->nullable();
            $table->string('num_factura')->nullable();
            $table->string('num_comprobante')->nullable();
            $table->date('fecha_factura')->nullable();
            $table->date('fecha_recibo')->nullable();
            $table->string('estado')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos');
    }
};