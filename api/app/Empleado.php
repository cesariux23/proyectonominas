<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
	protected $hidden = [
		'created_at',
		'updated_at'
	];

 	protected $fillable = [
 		'personal_id',
 		'tipo_contrato',
    	'tipo_nombramiento',
 		'numero_empleado',
 		'interinato',
		'puesto_id',
 		'status',
 		'fecha_alta',
 		'fecha_baja'
	];
	protected $appends = [
		'status_text'
	];

	protected $with = [
		'datos_personales',
		'status',
		'puesto_actual',
		'puesto_actual.adscripcion',
		'puesto_actual.plaza'
	];

 	// Datos personales
 	public function datos_personales()
 	{
 	 	return $this->belongsTo('App\Personal', 'personal_id', 'id');
	}
	// Status
	public function status()
	{
		return $this->belongsTo('App\status', 'status_id', 'id');
	}
	public function getStatusTextAttribute()
	{
		return $this->status->status;
	}
 	// puesto
 	public function puesto_actual()
 	 {
 	 	return $this->belongsTo('App\Puesto', 'puesto_id', 'id');
 	 }

 	// historial de puestos
 	public function historial()
 	{
		  return $this->hasMany('App\Puesto')
		  ->orderBy('fecha_fin', 'asc')
		  ->orderBy('fecha_inicio', 'desc');
	}

	public function scopeRfc($query, $value)
	{
		if ($value != null) {
			return $query->whereHas('datos_personales', function($q) use ($value){
				$q->where('rfc',$value);
			});
		}
	}

	public function scopeStatus($query, $value)
	{
		return $query->whereHas('status', function($q) use ($value){
			$q->where('status',$value);
		});
	}
	public function scopeTipoContrato($query, $value)
	{
		return $query->where('tipo_contrato',$value);
	}

}
