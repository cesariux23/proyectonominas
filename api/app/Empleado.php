<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Empleado extends Model
{
	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
 		'personal_id',
 		'tipo_contrato',
 		'numero_empleado',
 		'interinato',
		'puesto_id',
 		'status',
 		'fecha_alta',
 		'fecha_baja'
 	];

 	// Datos personales
 	public function datos_personales()
 	 {
 	 	return $this->belongsTo('App\Personal', 'personal_id', 'id');
 	 }

 	// puesto
 	public function puesto_actual()
 	 {
 	 	return $this->belongsTo('App\Puesto', 'puesto_id', 'id');
 	 }

 	// historial de puestos
 	public function historial()
 	 {
 	 	return $this->hasMany('App\Puesto');
 	 }
}