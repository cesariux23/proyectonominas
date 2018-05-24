<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
	protected $hidden = [
		'created_at',
		'updated_at'
	];

	protected $table = 'personal';

 	protected $fillable = [
 		'fecha_ingreso',
 		'rfc',
 		'curp',
 		'nss',
 		'fecha_nacimiento',
 		'sexo',
 		'nombre',
 		'primer_apellido',
 		'segundo_apellido',
 		'correo_electronico',
 		'tipo_pago',
 		'banco',
 		'numero_cuenta',
    'clabe'
 	];
 	protected $appends = [
 		'nombre_completo'
 	];

 	public function getNombreCompletoAttribute()
 	 {
 	 	$nombre = collect([]);
 	 	if(!is_null($this->primer_apellido)) $nombre->push($this->primer_apellido);
 	 	if(!is_null($this->segundo_apellido)) $nombre->push($this->segundo_apellido);
 	 	$nombre->push($this->nombre);
 	 	return $nombre->implode(' ');
 	 }
}
