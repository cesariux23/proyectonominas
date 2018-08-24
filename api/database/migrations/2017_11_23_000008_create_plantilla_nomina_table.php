<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillaNominaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'plantilla_nomina';

    /**
     * Run the migrations.
     * @table nomina
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->integer('tipo_nomina_id')->comment('ID del tipo de nomina asociado');
            $table->string('tipo_emision')->nullable()->default(null);
            $table->string('periodicidad')->nullable()->default(null);
            $table->integer('total_empleados')->default(0);
            $table->float('total_percepciones')->default(0);
            $table->float('total_excento_percepciones')->default(0);
            $table->float('total_deducciones')->default(0);
            $table->float('total_excento_deducciones')->default(0);
            $table->float('total_isr')->default(0);
            $table->float('total_neto')->default(0);
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
       Schema::dropIfExists($this->set_schema_table);
     }
}
