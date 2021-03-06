<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class ConceptoDesglose extends Model
{
	protected $table = 'concepto_desglose';
	
	protected $hidden = [
		'created_at',
		'updated_at'
	];

	protected $attributes = [
		'grabado' => 0,
		'excento' => 0,
    ];
	
 	protected $fillable = [
		 'concepto_id',
		 'desglose_nomina_id',
		 'descripcion',
		 'monto',
		 'grabado',
		 'excento',
		'record',
		'referencia_id',
		'numero_pago'
	 ];
	 protected $with = ['concepto'];
	 
	 public function concepto()
	 {
		return $this->belongsTo('App\CatalogoConcepto');
	 }

	 public function desglose()
	 {
		return $this->belongsTo('App\DesgloseNomina', 'desglose_nomina_id', 'id');
	 }
}