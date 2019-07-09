<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activo extends Model {
    use SoftDeletes;

    public function subproyecto(){
        return $this->belongsTo('App\Subproyecto');
    }

    public function archivos(){
        return $this->hasMany('App\Archivo');
    }

    public function comentarios(){
        return $this->hasMany('App\Comentario');
    }

    public function estrategias(){
        return $this->hasMany('App\Estrategia');
    }

    public function dpis() {
        return $this->belongsToMany('App\Dpi')->withPivot('tipo_asociacion', 'numero_registro');
    }

    public function dpiHerramientas() {
        return $this->hasMany('App\DpiHerramienta');
    }

    protected $dates = ['deleted_at'];
}
