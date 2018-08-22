<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConceptosNominaTable extends Migration
{

    // table name 
    public $set_schema_table = 'concepto_nomina';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->integer('concepto_id')->comment('id del concepto original')->unsigned();
            $table->integer('desglose_id')
                ->comment('id del desglose del empleado en nomina')
                ->unsigned();
            $table->string('comentario')
                ->nullable()
                ->default(null);
            $table->float('total')
                ->nullable()
                ->default(null);
            $table->float('grabado')
                ->nullable()
                ->default(null);
            $table->float('excento')
                ->nullable()
                ->default(null);
            $table->string('record')
                ->comment('conteo del pago, formato json(count, total)')
                ->nullable()
                ->default(null);
            $table->integer('referencia_id')
                ->comment('Procedente de la tabla conceptos referenciados')
                ->nullable()
                ->default(null);
            $table->integer('numero_pago')
                ->comment('indicador del pago, para generar el record')
                ->nullable()
                ->default(null);
            $table->timestamps();
            $table->foreign('concepto_id')->references('id')->on('catalogo_conceptos');
            $table->foreign('desglose_id')->references('id')->on('desglose_nominas')->onDelete('cascade');
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
