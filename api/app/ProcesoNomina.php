<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class ProcesoNomina extends Model
{
	protected $table = 'proceso_nomina';

	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
    'plantilla_nomina_id',
    'nomina_id'
  ];
  protected $with = ['nomina'];
  
  public function nomina()
  {
    return $this->belongsTo('App\Nomina', 'nomina_id', 'id');
  }
  public function plantilla()
  {
    return $this->belongsTo('App\PlantillaNomina', 'plantilla_nomina_id', 'id');
  }
}