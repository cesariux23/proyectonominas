<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogoNomina extends Model
{

	protected $hidden = [
		'created_at',
		'updated_at',
		'tipo_empleado'
	];
	protected $appends = [
		'aplica'
	];

 	protected $fillable = [
 		'descripcion',
 		'tipo_empleado',
 		'activa'
	];

	public function getAplicaAttribute()
	{
		return explode(',', $this->tipo_empleado);
	}
}
