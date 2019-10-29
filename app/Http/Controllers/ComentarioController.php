<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Trabajo;
use App\Comentario;
 
class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $idTrabajo = $request->idTrabajo;
        $trabajo = Trabajo::find($idTrabajo);
        $comentario = new Comentario();
        $comentario->contenido = $request->contenido;
        $comentario->idComentarioPadre = $request->idComentarioPadre;
        $comentario->idUsuario = \auth()->id();
        $comentario->idTrabajo = $idTrabajo;
 
        $trabajo->Comentarios()->save($comentario);
 
        return \redirect()->route('veranuncio', $idTrabajo);
    }
}