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
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('inscripcion_id');
            $table->string('cod_ceta');
            $table->string('kardex_economico');
            $table->decimal('monto', 10, 2);
            $table->date('fecha_pago');
            $table->unsignedBigInteger('cuota_id')->nullable();
            $table->string('tipo_pago')->nullable();
            $table->string('estado')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('forma_pago_id');
            $table->unsignedBigInteger('cuenta_bancaria_id')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('inscripcion_id')->references('id')->on('inscripciones');
            $table->foreign('cuota_id')->references('id')->on('cuotas');
            $table->foreign('forma_pago_id')->references('id')->on('formas_pago');
            $table->foreign('cuenta_bancaria_id')->references('id')->on('cuentas_bancarias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}; 