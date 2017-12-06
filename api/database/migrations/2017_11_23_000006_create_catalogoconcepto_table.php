<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogoconceptoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'catalogoconcepto';

    /**
     * Run the migrations.
     * @table catalogoconcepto
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->string('clave')->comment('Clave del concepto');
            $table->string('agrupador')
                ->nullable()
                ->default(null)
                ->comment('Algunos conceptos pueden agruparse para mejorar los reportes');
            $table->enum('tipo_concepto', ['PERCEPCION', 'DEDUCCION'])
                ->default('DEDUCCION')
                ->comment("Tipo de concepto");
            $table->string('descripcion')->comment('Descripcion o nombre del concepto');
            $table->string('tipo_empleado')
                ->nullable()
                ->default('BASE')
                ->comment('Tipo de empleado al que aplica');
            $table->float('monto')
                ->nullable()
                ->default(null)
                ->comment('Algunos conceptos son fijos y pueden tener un valor inicial');
            $table->float('porcentaje')
                ->nullable()
                ->default(null)
                ->comment('Algunos conceptos son relativos a un porcentaje sobre otro concepto');
            $table->boolean('excento')
                // se define exento porque por default se establece como tipo de concepto una deduccion
                ->default(true);
            $table
                ->boolean('fijable')
                ->default(true)
                ->comment('Se puede programar un periodo de aplicación');
            $table->timestamps();

            $table->unique(['descripcion'], 'descripcion');
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
