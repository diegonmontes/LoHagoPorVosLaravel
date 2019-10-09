<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //
    protected $table='rol';
    protected $primaryKey = 'idRol';
    protected $fillable = ['idRol', 'descripcionRol'];

    public function User()
    {
        return $this->belongsToMany('App\User', 'idRol', 'idRol');    
    }
}
