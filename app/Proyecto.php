<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model {
    
    protected $fillable = ['nombre', 'user_id', 'descripcion'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function activos(){
        return $this->hasMany('App\Activo');
    }

    public function sub_proyectos(){
        return $this->hasMany('App\Subproyecto');
    }

}
