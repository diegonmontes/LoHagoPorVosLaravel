<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Comentario extends Model
{
    protected $table='comentario';
    protected $primaryKey = 'idComentario';
    protected $fillable = [
        'comentario', 'idComentarioPadre', 'idTrabajo', 'idUsuario','idComentario'
    ];
 
    public function Trabajo() 
    {
        return $this->belongsTo('App\Trabajo', 'idTrabajo');
    }
 
    public function Usuario() 
    {
        return $this->belongsTo('App\User', 'idUsuario');
    }
 
    public function Parent() 
    {
        return $this->belongsTo('App\Comentario', 'idComentarioPadre');
    }
 
    public function Replies() 
    {
        return $this->hasMany('App\Comentario', 'idComentarioPadre');
    }
}