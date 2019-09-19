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
}
