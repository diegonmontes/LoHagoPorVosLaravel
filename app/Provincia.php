<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table='provincia';
    protected $primaryKey = 'idProvincia';
    protected $fillable = ['idProvincia', 'nombreProvincia','codigoIso31662'];

    public function Localidad()
    {
        return $this->hasMany('App\Localidad', 'idProvincia', 'idProvincia');
    }


}
