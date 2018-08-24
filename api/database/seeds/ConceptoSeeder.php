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
          'descripcion' => 'SUELDO BASE TABULAR',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE,CONFIANZA',
          'fijable' => true,
          'editable' => true,
          'excento' => false,
          'categoria' =>'PRESTACION DE LEY,TABULAR,SBC ISSSTE,SBC SAR'
        ],
        [
          'clave' => 'QUINQUENIO',
          'descripcion' => 'PRIMA QUINQUENIAL',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE,CONFIANZA',
          'fijable' => true,
          'editable' => true,
          'excento' => false,
          'categoria' =>"PRESTACION DE LEY,SBC ISSSTE,SBC SAR"
        ],
        [
          'clave' => 'CODECA',
          'descripcion' => 'COMPENSACIÓN POR DESARROLLO Y CAPACITACIÓN',
          'tipo' =>'PERCEPCION',
          'aplica' =>'BASE,CONFIANZA',
          'fijable' => true,
          'editable' => true,
          'excento' => false,
          'categoria' =>'PRESTACION DE LEY,SBC ISSSTE,SBC SAR'
        ], 
        [
          'clave' => 'C_GARANT',
          'descripcion' => 'COMPENSACIÓN GARANTIZADA',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE,CONFIANZA',
          'fijable' => true,
          'editable' => true,
          'excento' => false,
          'categoria' =>"PRESTACION DE LEY,TABULAR"
        ],
        [
          'clave' => 'PRIMA',
          'descripcion' => 'PRIMA VACACIONAL',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE,CONFIANZA',
          'fijable' => false,
          'editable' => true,
          'excento' => true,
          'max_excento' => 700.00,
          'categoria' =>"PRESTACION DE LEY,TABULAR"
        ],
        [
          'clave' => 'AHORRO',
          'descripcion' => 'FONAC',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'valor' => 234.00,
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => false,
          'categoria' =>'DEDUCCION PERSONAL'
        ]
      ];

      foreach ($conceptos as $concepto) {
        CatalogoConcepto::firstOrCreate($concepto);
      }
    }
}
