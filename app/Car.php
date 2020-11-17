<?php

/**
 * 
 * @author Francisco Roa <franroav@webkonce.cl>
 * 
 * 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';

    //relación todos los datos del usuario Modelo y Propuiedad a relacionar 
    public function user()
    {

        return $this->belongsTo('App\User', 'user_id');
    }
}
