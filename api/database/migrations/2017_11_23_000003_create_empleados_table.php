<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'empleados';

    /**
     * Run the migrations.
     * @table empleados
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->integer('personal_id')->unsigned();
            $table->enum('tipo_contrato', ['BASE', 'CONFIANZA', 'HONORARIOS'])->default('HONORARIOS');
            $table->string('numero_empleado');
            $table->integer('puesto_id')->unsigned()->nullable();
            $table->integer('status_id')
                ->comment('Status actual')
                ->unsigned();
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable();
            $table->timestamps();

            $table->foreign('personal_id')->references('id')->on('personal');

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
