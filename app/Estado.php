<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    //
    protected $table='estado';
    protected $primaryKey = 'idEstado';
    protected $fillable = ['idEstado', 'nombreEstado', 'descripcionEstado','eliminado'];

    public function Trabajo()
    {
        return $this->hasOne('App\Trabajo', 'idEstado', 'idEstado');
    }
}
