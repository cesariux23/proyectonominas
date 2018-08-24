<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class PlantillaNomina extends Model
{
	protected $table = 'plantilla_nomina';

	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
    'tipo_nomina_id',
    'tipo_emision',
    'periodicidad',
    'total_empleados',
    'status',
    'fecha_pago',
  ];
  
  public function tipoNomina()
  {
    return $this->belongsTo('App\CatalogoNomina', 'tipo_nomina_id', 'id');
  }

  public function desglose()
  {
    return $this->hasMany('App\DesglosePlantilla', 'plantilla_nomina_id', 'id');
  }
}