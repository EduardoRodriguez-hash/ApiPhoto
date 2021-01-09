<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->float('total');

            $table->unsignedBigInteger('id_estudio');
            $table->string('id_usuario',10);

            $table->foreign('id_estudio')->references('id')->on('estudios')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('id_usuario')->references('id')->on('usuarios')
            ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('contratos');
    }
}
