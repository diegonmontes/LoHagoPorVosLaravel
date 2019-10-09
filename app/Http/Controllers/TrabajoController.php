<?php

namespace App\Http\Controllers;

use App\CategoriaTrabajo;
use App\Trabajo;
use Illuminate\Http\Request;
use Auth;
use App\Persona;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Show the form for creating a new resource.
         */
        $listaCategoriaTrabajo=CategoriaTrabajo::all();
        return view('anuncio.index',['listaCategoriaTrabajo'=>$listaCategoriaTrabajo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[ 'titulo'=>'required', 'descripcion'=>'required', 'monto'=>'required', 'imagenTrabajo', 'tiempoExpiracion']);
        $request['idTipoTrabajo'] = 1;
        $idUsuario = Auth::user()->idUsuario;
        $persona = Persona::where('idUsuario','=',$idUsuario)->get();
        $request['idPersona']=$persona[0]->idPersona;
        Trabajo::create($request->all());
        return redirect()->route('inicio')->with('success','Registro creado satisfactoriamente');
    }
}
