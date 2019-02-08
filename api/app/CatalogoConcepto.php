<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class CatalogoConcepto extends Model
{
	protected $hidden = [
		'created_at',
		'updated_at',
		'aplica'
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
		'fijable',
		'orden',
		'auto',
		'visible'
	 ];
	 protected $appends = ['aplicaEmp'];

	 public function getAplicaEmpAttribute()
	 {
		 
		 return $this->aplica ? explode(',', $this->aplica) : [];
	 }
}