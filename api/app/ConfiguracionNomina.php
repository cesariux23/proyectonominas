<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionNomina extends Model
{

  protected $table = 'configuracion_nomina';

	protected $hidden = [
		'created_at',
		'updated_at'
	];

 	protected $fillable = [
 		'tipo',
 		'clave',
 		'valor',
    'nomina_id'
	];
}
