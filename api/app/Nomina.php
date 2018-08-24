<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Nomina extends Model
{
	protected $table = 'nominas';

	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
    'descripcion',
    'tipo_nomina_id',
    'tipo_emision',
    'periodicidad',
    'ejercicio',
    'fecha_inicio',
    'fecha_fin',
    'periodo',
    'total_empleados',
    'status',
    'fecha_pago',
  ];

  protected $with = ['tipoNomina'];
  
  public function tipoNomina()
  {
    return $this->belongsTo('App\CatalogoNomina', 'tipo_nomina_id', 'id');
  }
}