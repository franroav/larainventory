<?php

/**
 * 
 * @author Francisco Roa <franroav@webkonce.cl>
 * 
 * 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    //TABLE VENTAS 
    protected $table = 'ventas';

    // RELACIONES 
    public function user()
    {
        return $this->belongsTo('App\User', 'id_vendedor');
    }
}
