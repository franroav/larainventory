<?php

/**
 * 
 * @author Francisco Roa <franroav@webkonce.cl>
 * 
 * 
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instalador extends Model
{
    protected $table = 'instaladores';

    //Relación
    // mediante el id de la entidad se podra identificar. 
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
