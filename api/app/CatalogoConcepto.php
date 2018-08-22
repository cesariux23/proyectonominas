<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class CatalogoConcepto extends Model
{
	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
		 'clave',
		 'descripcion',
		 'tipo',
		 'descripcion',
		 'aplica',
		'monto',
		'porcentaje',
		'excento',
		'fijable'
 	];
}