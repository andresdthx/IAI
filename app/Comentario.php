<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model {
    public function activo(){
        return $this->belongsTo('App\Activo');
    }
}
