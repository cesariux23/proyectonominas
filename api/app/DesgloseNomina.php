<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesgloseNomina extends Model
{
	protected $hidden = [
		'created_at',
		'updated_at'
	];

 	protected $fillable = [
 		'empleado_id',
 		'nomina_id',
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
	
 	// Datos personales
 	public function empleado()
 	{
 	 	return $this->belongsTo('App\Empleado', 'empleado_id', 'id')->with('datos_personales',
		  'status',
		  'puesto_actual',
		  'puesto_actual.adscripcion',
		  'puesto_actual.plaza');
	}

	// Percepciones
	public function getPercepcionesAttribute()
	{
		 return \App\ConceptoNomina::whereHas('concepto', function($query) {
			 $query->where('tipo', 'PERCEPCION');
		 })
		 ->get();
   }

   // deducciones
	public function getDeduccionesAttribute()
	{
		 return \App\ConceptoNomina::whereHas('concepto', function($query) {
			 $query->where('tipo', 'DEDUCCION');
		 })
		 ->get();
   }
}
