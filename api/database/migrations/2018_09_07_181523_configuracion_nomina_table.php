<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConfiguracionNominaTable extends Migration
{
    public $set_schema_table = 'configuracion_nomina';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->integer('nomina_id')->comment('ID de la nomina asociado');
            $table->string('tipo')->comment('Indica si es un valor de configuracion, o un concepto')->nullable();
            $table->string('clave')->default('nombre de la clave');
            $table->integer('valor')->nullable()->default(null);
            $table->string('status')
                ->nullable()
                ->default('ACTIVO');
            $table->timestamps();

            $table->foreign('nomina_id')->references('id')->on('nomina')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->set_schema_table);
    }
}
