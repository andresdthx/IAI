<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subproyecto extends Model {

    public function proyecto() {
        return $this->belongsTo('App\Proyecto');
    }

    public function activos(){
        return $this->hasMany('App\Activo');
    }
}
