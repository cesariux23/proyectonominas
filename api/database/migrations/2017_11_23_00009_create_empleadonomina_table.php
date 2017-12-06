<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadonominaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'empleadonomina';

    /**
     * Run the migrations.
     * @table empleadonomina
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->integer('empleado')->nullable()->default(null);
            $table->integer('nomina')->nullable()->default(null);
            $table->float('total_percepciones')->nullable()->default(null);
            $table->float('total_excento_percepciones')->nullable()->default(null);
            $table->float('total_deducciones')->nullable()->default(null);
            $table->float('total_excento_deducciones')->nullable()->default(null);
            $table->float('total_isr')->nullable()->default(null);
            $table->float('total_neto')->nullable()->default(null);
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
