<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //
    protected $table='rol';
    protected $primaryKey = 'idRol';
    protected $fillable = ['idRol', 'descripcionRol'];

    public function Usuario()
    {
        return $this->hasMany('App\Usuario', 'idRol', 'idRol');    
    }
}
