<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesglosePlantilla extends Model
{
	protected $table = 'desglose_plantilla';

	protected $hidden = [
		'created_at',
		'updated_at'
	];

 	protected $fillable = [
 		'empleado_id',
 		'plantilla_nomina_id',
    	'total_percepciones',
 		'total_excento_percepciones',
 		'total_deducciones',
		'puesto_id',
 		'total_excento_deducciones',
 		'total_isr',
 		'total_neto'
	];

	protected $appends = [
		'percepciones',
		'deducciones',
	];

	protected $with = ['empleado'];
	
 	// Datos personales
 	public function empleado()
 	{
 	 	return $this->belongsTo('App\Empleado', 'empleado_id', 'id')->with('datos_personales',
		  'status',
		  'puesto_actual',
		  'puesto_actual.adscripcion',
		  'puesto_actual.plaza');
	}

	public function plantilla()
 	{
 	 	return $this->belongsTo('App\PlantillaNomina', 'plantilla_nomina_id', 'id');
	}

	// Percepciones
	public function getPercepcionesAttribute()
	{
		 return \App\ConceptoDesglose::whereHas('concepto', function($query) {
			 $query->where('tipo', 'PERCEPCION');
		 })
		 ->where('desglose_plantilla_id', $this->id)
		 ->get();
   }

   // deducciones
	public function getDeduccionesAttribute()
	{
		 return \App\ConceptoDesglose::whereHas('concepto', function($query) {
			 $query->where('tipo', 'DEDUCCION');
		 })
		 ->where('desglose_plantilla_id', $this->id)
		 ->get();
   }

   // Calcula el valor del desglose
   public function calcula($calcula_plantilla = true)
   {
	   //percepciones
	   $percepciones = $this->percepciones;
	   $suma_percepciones = $this->sumaConceptos($percepciones);
	   $this->total_percepciones = $suma_percepciones->total;
	   $this->total_excento_percepciones = $suma_percepciones->excento;
	   $suma_categoria = $this->sumaPorCategoria($percepciones, ['SBC ISSSTE', 'SBC SAR', 'SUELDO']);

	   // DEDUCCIONES ISSSTE
	   $this->calculaPorcentajes(array_key_exists('SBC ISSSTE', $suma_categoria) ? $suma_categoria['SBC ISSSTE'] : 0, 'ISSSTE');
	   $this->calculaPorcentajes(array_key_exists('SBC ISSSTE', $suma_categoria) ? $suma_categoria['SBC ISSSTE'] : 0, 'SEG_MEDICO');

	   //Cuota Sindical
	   $this->calculaPorcentajes(array_key_exists('SUELDO', $suma_categoria) ? $suma_categoria['SUELDO'] : 0, 'CUOTA_SIN');

	   //deducciones
	   $deducciones = $this->sumaConceptos($this->deducciones, ['ISR']);
	   $this->total_deducciones = $deducciones->total;
	   $this->total_excento_deducciones = $deducciones->excento;

	   //impuesto
	   $base_grabable = $suma_percepciones->grabado + $deducciones->grabado;
	   $this->calculaImpuestos($base_grabable);
	   
	   $this->save();

	   if ($calcula_plantilla) {
		   //Se calcula el total de la plantilla
	   		$this->plantilla->calcula();
	   }

	   
   }

   //genera el total  de la array
   public function sumaConceptos($conceptos, $except = null)
   {
	   	$total =(object)[
			'total' => 0,
			'excento' => 0,
			'grabado' => 0
	   	];
	   	foreach ($conceptos as $concepto) {
			if ($except && in_array($concepto->concepto->clave, $except)) {
				continue;
			}
			$total->total += $concepto->monto;
			$total->excento += $concepto->excento;
			$total->grabado += $concepto->grabado;
		}
		
		return $total;
   }

   public function calculaImpuestos($base_grabable)
   {
	   # code..
   }

   public function sumaPorCategoria($conceptos, $categorias)
   {
	   $sumas = [];
	   foreach ($conceptos as $key => $concepto) {
		   $cats =explode(',', $concepto->concepto->categoria);
		   foreach ($categorias as $key => $cat) {
			   if (in_array($cat,  $cats)) {
					$sumas[$cat] = array_key_exists($cat, $sumas) ? $sumas[$cat] += $concepto->monto : $concepto->monto;
			   }
		   }
	   }
	   return $sumas;
   }

   public function calculaPorcentajes($base, $clave, $eliminar=true)
   {
		$concepto = \App\CatalogoConcepto::where('clave', $clave)->first();
		$concepto_aplicar = \App\ConceptoDesglose::firstOrNew(['concepto_id' => $concepto->id, 'desglose_plantilla_id' => $this->id]);
		if ($base > 0) {
			$issste = round(($base * $concepto->valor) / 100, 2);
			if (!$concepto_aplicar->id) {
				$concepto_aplicar->descripcion = $concepto->descripcion;
			}
			$concepto_aplicar->monto = $issste;
			$concepto_aplicar->save();   
		} else {
			if ($eliminar) {
				// se elimina el concepto
				if($concepto_aplicar->id) {
					$concepto_aplicar->delete();
				}
			}
		}
   }
}
