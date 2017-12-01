<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Puesto extends Model
{
	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
 		'empleado_id',
 		'funcion',
 		'adscripcion_id',
		'plaza_id',
		'status_general',
		'status',
		'historico',
		'interinato',
		'referencia', 
 		'fecha_inicio',
 		'fecha_fin',
 	];

 	// puesto
 	public function adscripcion()
 	 {
 	 	return $this->belongsTo('App\Adscripcion', 'adscripcion_id', 'id');
 	 } 

 	public function plaza()
 	 {
 	 	return $this->belongsTo('App\Plaza', 'plaza_id', 'id');
 	 } 
}