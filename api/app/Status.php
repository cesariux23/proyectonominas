<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Status extends Model
{

    protected $table = 'status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'substatus',
        'empleado_id',
        'personal_id',
        'observaciones',
        'fecha_inicio',
        'fecha_fin',
        'antiguedad'
    ];
}
