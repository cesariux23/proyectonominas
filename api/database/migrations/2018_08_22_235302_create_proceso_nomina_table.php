<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesoNominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('proceso_nomina')) return;
        Schema::create('proceso_nomina', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nomina_id')->unsigned()->comment('ID de la nomina');
            $table->integer('plantilla_nomina_id')->unsigned()->comment('ID del proceso de la plantilla de nomina');
            $table->string('status')
                ->default('EN PROCESO');
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
        Schema::dropIfExists('nomina_proceso');
    }
}
