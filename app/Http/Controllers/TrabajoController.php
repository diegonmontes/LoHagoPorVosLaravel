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
        //
        $listaCategoriaTrabajo=CategoriaTrabajo::all();
        return view('anuncio.index',['listaCategoriaTrabajo'=>$listaCategoriaTrabajo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $this->validate($request,[ 'titulo'=>'required', 'descripcion'=>'required', 'monto'=>'required']);
        $request['idTipoTrabajo'] = 1;
        $idUsuario = Auth::user()->idUsuario;
        $persona = Persona::where('idUsuario','=',$idUsuario)->get();
        $request['idPersona']=$persona[0]->idPersona;
        Trabajo::create($request->all());
        return redirect()->route('provincia.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
