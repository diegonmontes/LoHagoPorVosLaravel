<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    //
    protected $table='estado';
    protected $primaryKey = 'idEstado';
    protected $fillable = ['idEstado', 'nombreEstado', 'descripcionEstado'];

    public function Trabajo()
    {
        return $this->hasMany('App\Trabajo', 'idEstado', 'idEstado');
    }
}
