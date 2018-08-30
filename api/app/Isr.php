<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Isr extends Model
{
	protected $table = 'isr';

	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
 		'ejercicio',
 		'periodo',
 		'limite_inferior',
		'limite_superior',
		'cuota_fija',
		'sobre_exedente'
 	];
}