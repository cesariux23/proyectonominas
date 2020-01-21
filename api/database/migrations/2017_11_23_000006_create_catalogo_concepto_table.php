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
                ->comment('Tipo de empleado al que aplica, puede almacenarse como un array (separdo por comas)');
            $table->double('valor')
                ->nullable()
                ->default(null)
                ->comment('Algunos conceptos son fijos y pueden tener un valor inicial');
            $table->string('tipo_valor')
                ->nullable()
                ->default('$');
                $table->string('formula')
                ->nullable();
            $table->boolean('excento')
                ->comment('Se puede exentar alguna parte del concepto')
                ->default(true);
            $table->float('max_excento')
                ->nullable()
                ->default(null)
                ->comment('monto maximo a exentar, si se define no podra editarse');
            $table
                ->integer('orden')
                ->default(99)
                ->comment('orden para mostrar');
            $table
                ->boolean('editable')
                ->default(true)
                ->comment('Se puede editar libremente');
            $table
                ->boolean('auto')
                ->default(false)
                ->comment('Se inicializa la nomina con  estos valores');
            $table
                ->boolean('visible')
                ->default(true)
                ->comment('Se esta disponible para agregar libremente');
            $table
                ->boolean('fijable')
                ->default(true)
                ->comment('Se puede programar un periodo de aplicación');            
            $table
                ->string('categoria')
                ->default('DEDUCCIONES EN GENERAL')
                ->comment('Categoria del concepto');
            $table
                ->string('status')
                ->default('ACTIVO')
                ->comment('Estatus del concepto');
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
