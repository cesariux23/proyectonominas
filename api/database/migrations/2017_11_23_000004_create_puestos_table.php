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
            $table->string('funcion');
            $table->integer('adscipcion_id')->unsigned();
            $table->integer('plaza_id')->unsigned()->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('adscipcion_id')->references('id')->on('adscripciones');
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
