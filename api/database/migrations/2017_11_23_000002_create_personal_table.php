<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'personal';

    /**
     * Run the migrations.
     * @table personal
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id', true);
            $table->date('fecha_ingreso')->nullable();
            $table->string('rfc');
            $table->string('curp')->nullable();
            $table->string('nss')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('nombre');
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('tipo_pago')->default('DEPOSITO');
            $table->string('banco')->nullable()->default(null);
            $table->string('numero_cuenta')->nullable()->default(null);

            $table->unique(["rfc"], 'rfc');
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
