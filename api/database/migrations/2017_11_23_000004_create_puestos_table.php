<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuestosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'puestos';

    /**
     * Run the migrations.
     * @table puestos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->increments('id', true);
            $table->engine = 'InnoDB';
            $table->integer('empleado_id')->unsigned();
            $table->string('tipo_nombramiento')->nullable()->default(null);
            $table->string('funcion')->comment('Funcion que desempeña dentro del instituto')->default('AUXILIAR');
            $table->integer('adscripcion_id')->unsigned();
            $table->integer('plaza_id')->unsigned()->comment('Id de la plaza, solo aplica para tipo de personal que esta en plantilla')->nullable();
            $table->string('historico')->comment('Se marca si este puesto ya se considera como histortico')->default(false);
            $table->boolean('laboral')->comment('Se marca como periodo laborado, considerado para el calculo de antiguedades')->default(true);
            $table->integer('referencia')->unsigned()->comment('ID del empleado, referencia al empleado que se esta cubriendo en el interinato')->default(true);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
            
            $table->foreign('empleado_id')->references('id')->on('empleados')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('adscripcion_id')->references('id')->on('adscripciones');
            $table->foreign('plaza_id')->references('id')->on('plazas');



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
