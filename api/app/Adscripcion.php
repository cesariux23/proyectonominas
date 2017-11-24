<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Adscripcion extends Model
{
	protected $table= 'adscripciones';
	protected $hidden = [
		'created_at',
		'updated_at'
	];
	
 	protected $fillable = [
 		'nombre',
 		'unidad',
 		'subunidad',
 	];
}