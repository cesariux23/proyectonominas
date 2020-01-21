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
          'editable' => true,
          'excento' => false,
          'orden' => 0,
          'auto' => true,
          'categoria' =>'PRESTACION DE LEY,TABULAR,SBC ISSSTE,SBC SAR,SUELDO'
        ],
        [
          'clave' => 'QUINQUENIO',
          'descripcion' => 'PRIMA QUINQUENIAL',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE,CONFIANZA',
          'fijable' => true,
          'orden' => 0,
          'auto' => true,
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
          'orden' => 1,
          'auto' => true,
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
          'orden' => 1,
          'auto' => true,
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
          'orden' => 1,
          'auto' => true,
          'fijable' => true,
          'editable' => false,
          'excento' => false,
          'categoria' =>'PRESTACION DE LEY'
        ],
        [
          'clave' => 'PREVISION_SOCIAL',
          'descripcion' => 'PREVISION SOCIAL MULTIPLE',
          'tipo' =>'PERCEPCION',
          'aplica' =>'BASE,CONFIANZA',
          'valor'=> 257.5,
          'orden' => 1,
          'auto' => true,
          'fijable' => true,
          'editable' => false,
          'excento' => false,
          'categoria' =>'PRESTACION DE LEY'
        ],
        [
          'clave' => 'C_GARANT',
          'descripcion' => 'COMPENSACIÓN GARANTIZADA',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE,CONFIANZA',          
          'orden' => 0,
          'auto' => true,
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
          'clave' => 'GRATIFICACION',
          'descripcion' => 'GRATIFICACIÓN',
          'tipo' =>'PERCEPCION',
          'aplica' => 'HONORARIOS',
          'tipo_valor' => '$',
          'fijable' => true,
          'excento' => false,
          'orden' => 0,
          'editable' => true
        ],
        [
          'clave' => 'PUNTUALIDAD_MENSUAL',
          'descripcion' => 'PUNTUALIDAD MENSUAL',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE',
          'formula' => '(SUELDO/15)*1|SUELDO|0',
          'valor' => '1',
          'orden' => 2,
          'excento' => false,
        ],
        [
          'clave' => 'PUNTUALIDAD_PERFECTA',
          'descripcion' => 'PUNTUALIDAD PERFECTA',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE',
          'tipo_valor' => 'DIAS[SUELDO]',
          'valor' => '12',
          'orden' => 2,
          'excento' => false,
        ],
        [
          'clave' => 'GUARDERIA',
          'descripcion' => 'GUARDERÍA CONTRACTUAL',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE',
          'tipo_valor' => '$',
          'orden' => 2,
          'excento' => false,
        ],
        [
          'clave' => 'PRODUCTIVIDAD_MESUAL',
          'descripcion' => 'PRODUCTIVIDAD MENSUAL',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE',
          'tipo_valor' => '$',
          'valor' => 700,
          'orden' => 3,
          'excento' => false,
        ],
        [
          'clave' => 'PRODUCTIVIDAD_TRIMESTRAL',
          'descripcion' => 'PRODUCTIVIDAD TRIMESTRAL TD',
          'tipo' =>'PERCEPCION',
          'aplica' => 'BASE',
          'tipo_valor' => '$',
          'orden' => 3,
          'excento' => false,
        ],
        [
          'clave' => 'DEVOLUCION',
          'descripcion' => 'DEVOLUCIÓN POR DESCUENTO INDEBIDO',
          'tipo' =>'PERCEPCION',
          'tipo_valor' => '$',
          'excento' => true,
        ],
        [
          'clave' => 'AJUSTE',
          'descripcion' => 'PRESTAMO POR AJUSTE',
          'tipo' =>'PERCEPCION',
          'tipo_valor' => '$',
          'excento' => false,
        ],
        // DEDUCCIONES
        [
          'clave' => 'ISR',
          'descripcion' => 'ISR',
          'tipo' =>'DEDUCCION',
          'tipo_valor' => '$',
          'editable' => false,
          'visible' => false,
          'categoria' =>'ISR'
        ],
        [
          'clave' => 'AHORRO',
          'descripcion' => 'FONAC',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'valor' => 234,
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => false,
          'auto' => true,
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
          'categoria' =>'ISSSTE',
          'visible' => false,
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
          'categoria' =>'ISSSTE',
          'visible' => false,
        ],
        [
          'clave' => 'CUOTA_SIN',
          'descripcion' => 'CUOTA SINDICAL',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE',
          'valor' => 2.5,
          'tipo_valor' => '%',
          'fijable' => true,
          'editable' => false,
          'visible' => false,
        ],
        [
          'clave' => 'SEGURO_RETIRO',
          'descripcion' => 'SEGURO DE RETIRO',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'valor' => 7.27,
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => false,
          'auto' => true
        ],
        [
          'clave' => 'POTEN',
          'descripcion' => 'POTENCIALIZACIÓN DEL SEGURO DE VIDA',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE,CONFIANZA',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true,
          'auto' => true,
        ],
        [
          'clave' => 'METLIFE',
          'descripcion' => 'SEGURO DE VIDA INDIVIDUAL METLIFE',
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
          'clave' => 'PHIPO',
          'descripcion' => 'PRESTAMO HIPOTECARIO',
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
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
        [
          'clave' => 'MUTUAL',
          'descripcion' => 'FONDO MUTUALISTA SNTEA',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
        [
          'clave' => 'FAR',
          'descripcion' => 'FAR SNTEA',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE',
          'tipo_valor' => '$',
          'valor' => 5,
          'fijable' => true,
          'editable' => true,
          'auto' => true
        ],
        [
          'clave' => 'PENSION_ALIMENTICIA',
          'descripcion' => 'PENSIÓN ALIMENTICIA',
          'tipo' =>'DEDUCCION',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true,
          'visible' => false
        ],
        [
          'clave' => 'PAPELERIA',
          'descripcion' => 'DESCUENTO PAPELERIA',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
        [
          'clave' => 'FAMSA',
          'descripcion' => 'FAMSA',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
        [
          'clave' => 'ELECTRODOMESTICOS',
          'descripcion' => 'ELECTRODOMESTICOS',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE',
          'tipo_valor' => '$',
          'fijable' => true,
          'editable' => true
        ],
        [
          'clave' => 'FARMACIA',
          'descripcion' => 'FARMACIA DEL MAGISTERIO',
          'tipo' =>'DEDUCCION',
          'aplica' => 'BASE',
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
