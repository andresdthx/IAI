<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpi extends Model {

    public function activos(){
        return $this->belongsToMany('App\Activo')->withPivot('tipo_asociacion');;
    }

    public function herramientas(){
        return $this->belongsToMany('App\Herramienta');
    }

    public function dpiHerramientas() {
        return $this->hasMany('App\DpiHerramienta');
    }
    
}
