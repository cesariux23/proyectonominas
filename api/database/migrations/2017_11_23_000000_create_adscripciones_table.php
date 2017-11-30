<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdscripcionesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'adscripciones';

    /**
     * Run the migrations.
     * @table adscripciones
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->integer('unidad')->nullable()->default(null);
            $table->integer('subunidad')->nullable()->default(null);
            $table->string('nombre');
            $table->boolean('activa')->default(true);
            $table->timestamps();

            $table->unique(["nombre"], 'nombre');
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
