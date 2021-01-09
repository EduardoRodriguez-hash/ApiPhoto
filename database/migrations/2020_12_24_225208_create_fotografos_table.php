<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotografosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotografos', function (Blueprint $table) {
            $table->string('id', 10);
            $table->string('nombre', 60);
            $table->string('apellido', 60);
            $table->string('telefono', 10);

            $table->unsignedBigInteger('id_estudio');
            $table->foreign('id_estudio')->references('id')->on('estudios')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary('id');
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
        Schema::dropIfExists('fotografos');
    }
}
