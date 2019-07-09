<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model {

    public function dpis() {
        return $this->belongsToMany('App\Dpi');
    }

    public function dpiHerramientas() {
        return $this->hasMany('App\DpiHerramienta');
    }
    
}
