<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DpiHerramienta extends Model{

    protected $table = 'dpiherramientas';

    public function activo() {
        return $this->belongsTo('App\Activo');
    }

    public function herramienta(){
        return $this->belongsTo('App\Herramienta');
    }

    public function dpi(){
        return $this->belongsTo('App\Dpi');
    }

}
