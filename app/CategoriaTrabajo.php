<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaTrabajo extends Model
{
    //
    protected $table='categoriaTrabajo';
    protected $primaryKey='idCategoriaTrabajo';
    protected $fillable = ['idCategoriaTrabajo', 'nombreCategoriaTrabajo'];

    public function Trabajo()
    {
        return $this->hasMany('App\Trabajo', 'idCategoriaTrabajo', 'idCategoriaTrabajo');
    }
}
