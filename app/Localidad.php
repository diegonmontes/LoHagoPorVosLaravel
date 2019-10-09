<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    //
    protected $table='localidad';
    protected $primaryKey = 'idLocalidad';
    protected $fillable = ['idLocalidad', 'nombreLocalidad','idProvincia','codigoPostal'];

    public function Provincia()
    {
        return $this->belongsTo('App\Provincia', 'idProvincia', 'idProvincia');
    }

    public function Persona()
    {
        return $this->belongTo('App\Persona', 'idLocalidad', 'idLocalidad');
    }

    public function Trabajo()
    {
        return $this->hasMany('App\Trabajo', 'idTrabajo', 'idTrabajo');
    }
}
