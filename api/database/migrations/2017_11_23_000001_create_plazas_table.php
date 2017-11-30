<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlazasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'plazas';

    /**
     * Run the migrations.
     * @table plazas
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->string('clave');
            $table->string('codigo')->nullable()->default(null);
            $table->string('nombre')->comment('Descripcion de la plaza');
            $table->enum('tipo', ['BASE', 'CONFIANZA', 'HONORARIOS']);
            $table->string('nivel')->nullable()->default('2');
            $table->integer('zona')->nullable()->default(2);
            $table->integer('autorizadas')->comment('Numero de plazas autorizadas')->default(0);
            $table->integer('ocupadas')->comment('Contador de plazas de plazas ocupadas')->default(0);
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
