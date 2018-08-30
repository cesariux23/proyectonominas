<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsrTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'isr';

    /**
     * Run the migrations.
     * @table isr
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ejercicio');
            $table->string('periodo')->comment("Quincenal, mensual o anual");
            $table->float('limite_inferior')->nullable()->default(null);
            $table->float('limite_superior')->nullable()->default(null);
            $table->float('cuota_fija')->nullable()->default(null);
            $table->float('sobre_excedente')->nullable()->default(null);
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
