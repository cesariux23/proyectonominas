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
	
 	protected $fillable = [
		 'concepto_id',
		 'desglose_plantilla_id',
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
		return $this->belongsTo('App\CatalogoConcepto', 'concepto_id', 'id');
	 }
}