<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model {
    public $incrementing = false;
    
    public function activo(){
        return $this->belongsTo('App\Activo');
    }

    
}
