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
    'total_percepciones',
    'total_excento_percepciones',
    'total_deducciones',
    'total_excento_deducciones',
    'total_isr',
    'total_neto'
  ];

  protected $with = ['tipoNomina'];
  
  public function tipoNomina()
  {
    return $this->belongsTo('App\CatalogoNomina', 'tipo_nomina_id', 'id');
  }

  public function desglose()
  {
    return $this->hasMany('App\DesgloseNomina', 'nomina_id', 'id');
  }
  public function calcula()
  {
    $totales =[
      'total_percepciones' => 0,
      'total_excento_percepciones' => 0,
      'total_deducciones' => 0,
      'total_excento_deducciones' => 0,
      'total_isr' => 0,
      'total_neto'=> 0
	  ];
    foreach ($this->desglose as $desglose) {
      foreach ($totales as $key => $valor) {
        $totales[$key] += $desglose->{$key};
      }
    }
    $this->update($totales);
  }
}