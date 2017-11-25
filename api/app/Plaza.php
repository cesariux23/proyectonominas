<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Plaza extends Model
{
	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
 		'clave',
 		'codigo',
 		'nivel',
 		'zona'
 	];
}