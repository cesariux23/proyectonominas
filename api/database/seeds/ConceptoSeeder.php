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
          'categoria' =>'PRESTACION DE LEY,TABULAR,SBC ISSSTE,SBC SAR,SUELDO'
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
          'valor' => 750.0,
          'fijable' => true,
          'editable' => false,
          'excento' => false,
          'categoria' =>'PRESTACION DE LEY,SBC ISSSTE,SBC SAR'
        ],
        [
          'clave' => 'DESPENSA',
          'descripcion' => 'DESPENSA',
          'tipo' =>'PERCEPCION',
          'aplica' =>'BASE,CONFIANZA',
          'valor'=> 342.5,
          'fijable' => true,
          'editable' => false,
          'excento' => false,
          'categoria' =>'PRESTACION DE LEY'
        ],
        [
          'clave' => 'AYUDA_SERVICIOS',
          'descripcion' => 'AYUDA POR SERVICIOS',
          'tipo' =>'PERCEPCION',
          'aplica' =>'BASE,CONFIANZA',
          'valor'=> 247.5,
          'fijable' => true,
          'editable' => true,
          'excento' => false,
          'categoria' =>'PRESTACION DE LEY'
        ],
        [
          'clave' => 'PREVISION_SOCIAL',
          'descripcion' => 'PREVISION SOCIAL MULTIPLE',
          'tipo' =>'PERCEPCION',
          'aplica' =>'BASE,CONFIANZA',
          'valor'=> 257.5,
          'fijable' => true,
          'editable' => true,
          'excento' => false,
          'categoria' =>'PRESTACION DE LEY'
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

        // DEDUCCIONES
        [
          'clave' => 'AHORRO',
          'descripcion' => 'FONAC',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'valor' => 234,
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => false,
          'categoria' =>'DEDUCCION PERSONAL'
        ],
        [
          'clave' => 'ISSSTE',
          'descripcion' => 'ISSSTE',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'valor' => 6.125,
          'tipo_valor' => '%',
          'fijable' => true,
          'editable' => false,
          'categoria' =>'ISSSTE'
        ],
        [
          'clave' => 'SEG_MEDICO',
          'descripcion' => 'SEGURO MEDICO ISSSTE',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'valor' => 4.5,
          'tipo_valor' => '%',
          'fijable' => true,
          'editable' => false,
          'categoria' =>'ISSSTE'
        ],
        [
          'clave' => 'CUOTA_SIN',
          'descripcion' => 'CUOTA SINDICAL',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE',
          'valor' => 2.5,
          'tipo_valor' => '%',
          'fijable' => true,
          'editable' => false
        ],
        [
          'clave' => 'SEGURO_RETIRO',
          'descripcion' => 'SEGURO DE RETIRO',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'valor' => 7.27,
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => false
        ],
        [
          'clave' => 'POTEN',
          'descripcion' => 'POTENCIALIZACIÓN DEL SEGURO DE VIDA',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
        [
          'clave' => 'METLIFE',
          'descripcion' => 'SEGURO DE VIDA METLIFE',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
        [
          'clave' => 'PCP',
          'descripcion' => 'PRESTAMO A CORTO PLAZO',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
        [
          'clave' => 'ADEUDO_FINANZAS',
          'descripcion' => 'ADEUDO A FINANZAS',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
      ];

      foreach ($conceptos as $concepto) {
        CatalogoConcepto::firstOrCreate($concepto);
      }
    }
}
