<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->string('substatus')->nulleable()->default(null);
            $table->integer('empleado_id')->unsigned();
            $table->integer('personal_id')->unsigned();
            $table->string('observaciones')->nulleable()->default(null);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->boolean('antiguedad')
                ->comment('Indica si debe tomarse para el calculo de la antiguedad')
                ->nullable()
                ->default(null);
            $table->timestamps();

            $table->foreign('personal_id')->references('id')->on('personal')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status');
    }
}
