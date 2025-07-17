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
        Schema::create('costo_aplicado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('costo_id');
            $table->string('tipo_usuario');
            $table->string('concepto');
            $table->decimal('monto', 10, 2);
            $table->date('vigencia_inicio')->nullable();
            $table->date('vigencia_fin')->nullable();
            $table->string('estado')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('costo_id')->references('id')->on('costos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costo_aplicado');
    }
};