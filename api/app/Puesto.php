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
 		'fecha_inicio',
 		'fecha_fin',
 	];

 	// puesto
 	public function adscripcion()
 	 {
 	 	return $this->belongsTo('App\Adscripcion', 'adscripcion_id', 'id');
 	 } 
}