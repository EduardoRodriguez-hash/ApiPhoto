<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->float('total');
            $table->unsignedBigInteger('id_foto');
            $table->string('id_usuario', 10);

            $table->foreign('id_foto')->references('id')->on('fotos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_usuario')->references('id')->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('nota_ventas');
    }
}
