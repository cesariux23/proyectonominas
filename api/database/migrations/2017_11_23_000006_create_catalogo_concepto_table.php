<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogoConceptoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'catalogo_conceptos';

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
            $table->enum('tipo', ['PERCEPCION', 'DEDUCCION'])
                ->default('DEDUCCION')
                ->comment("Tipo de concepto");
            $table->string('descripcion')->comment('Descripcion o nombre del concepto');
            $table->string('aplica')
                ->nullable()
                ->default('BASE')
                ->comment('Tipo de empleado al que aplica, puede almacenarse como un array (json)');
            $table->float('valor')
                ->nullable()
                ->default(null)
                ->comment('Algunos conceptos son fijos y pueden tener un valor inicial');
            $table->string('tipo_valor')
                ->nullable()
                ->default('$');
            $table->boolean('excento')
                ->comment('Se puede exentar alguna parte del concepto, la deducciones se excentan por lo general al 100%')
                ->default(true);
            $table
                ->boolean('editable')
                ->default(true)
                ->comment('Se puede editar libremente');
            $table
                ->boolean('tabular')
                ->default(false)
                ->comment('Se debe de verificar con el tabulador existente');
            $table
                ->boolean('fijable')
                ->default(true)
                ->comment('Se puede programar un periodo de aplicación');
            $table->timestamps();
            $table->unique(['clave'], 'clave');
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
