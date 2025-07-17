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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('inscripcion_id');
            $table->string('cod_ceta');
            $table->string('cod_inscrip');
            $table->string('cod_pensum');
            $table->string('gestion');
            $table->string('kardex_economico');
            $table->integer('num_pago_matri');
            $table->decimal('costo', 10, 2);
            $table->decimal('descuento', 10, 2);
            $table->decimal('matriculatotal', 10, 2);
            $table->boolean('pago_completo');
            $table->string('num_factura')->nullable();
            $table->string('num_comprobante')->nullable();
            $table->dateTime('fecha_pago');
            $table->string('razon')->nullable();
            $table->string('nit')->nullable();
            $table->string('autorizacion')->nullable();
            $table->string('valido')->nullable();
            $table->string('concepto')->nullable();
            $table->string('codigo_control')->nullable();
            $table->string('code_tipo_pago')->nullable();
            $table->string('nro_cuenta')->nullable();
            $table->string('nro_deposito')->nullable();
            $table->date('fecha_deposito')->nullable();
            $table->string('nro_nota')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('inscripcion_id')->references('id')->on('inscripciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}; 