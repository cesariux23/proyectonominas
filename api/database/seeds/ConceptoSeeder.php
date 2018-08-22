<?php

use Illuminate\Database\Seeder;

use App\CatalogoConcepto;

class ConceptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $conceptos = [
        [
          'clave' => 'SUELDO',
          'descripcion' => 'Sueldo base tabular',
          'tipo' =>'PERCEPCION',
          'aplica' => "['BASE','CONFIANZA']",
          'fijable' => true,
          'editable' => true,
          'excento' => false,
          'tabular' => true
        ],
        [
          'clave' => 'AHORRO',
          'descripcion' => 'FONAC',
          'tipo' =>'DEDUCCION',
          'aplica' => "['BASE','CONFIANZA']",
          'valor' => 234.00,
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => false,
          'excento' => true,
          'tabular' => true
        ]
      ];

      foreach ($conceptos as $concepto) {
        CatalogoConcepto::firstOrCreate($concepto);
      }
    }
}
