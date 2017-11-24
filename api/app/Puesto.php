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
 		'adscipcion_id',
 		'plaza_id',
 		'fecha_inicio',
 		'fecha_fin',
 	];

 	// puesto
 	public function adscripcion()
 	 {
 	 	return $this->belongsTo('App\Adscripcion', 'adscipcion_id', 'id');
 	 } 
}