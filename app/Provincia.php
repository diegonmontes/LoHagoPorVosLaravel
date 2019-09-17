<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{	
    protected $table='provincia';
    protected $primaryKey = 'idProvincia';
    protected $fillable = ['idProvincia', 'nombreProvincia'];

    public function Localidad()
    {
        return $this->hasMany('App\Localidad', 'idLocalidad', 'idProvincia');    
    }
}
