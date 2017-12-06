<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'nomina';

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
            $table->integer('tipo_nomina')->comment('ID del tipo de nomina asociado');
            $table->string('tipo_emision')->default('QUINCENAL');
            $table->string('descripcion')->nullable()->default(null);
            $table->integer('ejercicio')->nullable()->default(null);
            $table->date('fecha_inicio')->nullable()->default(null);
            $table->string('periodo_inicio')->nullable()->default(null);
            $table->date('fecha_fin')->nullable()->default(null);
            $table->string('periodo_fin')->nullable()->default(null);
            $table->float('total_percepciones')->nullable()->default(null);
            $table->float('total_excento_percepciones')->nullable()->default(null);
            $table->float('total_deducciones')->nullable()->default(null);
            $table->float('total_excento_deducciones')->nullable()->default(null);
            $table->float('total_isr')->nullable()->default(null);
            $table->float('total_neto')->nullable()->default(null);
            $table->string('status')
                ->default('ACTIVO')
                ->comment('Determina el estatus de la nomina ue puede estar activa, cancelada, pagada, etc.');
            $table->date('fecha_pago')->nullable()->default(null);

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
