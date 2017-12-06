<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class CatalogoNomina extends Model
{
	protected $table = 'catalogonomina';

	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
 		'descripcion',
 		'codtipo_empleadoigo',
 		'activa'
 	];
}