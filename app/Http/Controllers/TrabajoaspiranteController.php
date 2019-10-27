<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trabajoaspirante;
use App\Persona;
use App\Trabajo;
use Auth;

class TrabajoaspiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        //Buscamos la persona que esta autenticada con el idUsuario
        $idUsuario = Auth::user()->idUsuario;
        $persona = Persona::where('idUsuario','=',$idUsuario)->get()[0];
        //Buscamos el trabajo que se quiere postular
        $trabajo = Trabajo::find($id);
        return view('trabajoaspirante.index',['persona'=>$persona, 'trabajo'=>$trabajo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $listaPersonas = Persona::all();
        $listaTrabajos = Trabajo::all();
        return view('trabajoaspirante.create',['listaPersonas'=>$listaPersonas,'listaTrabajos'=>$listaTrabajos]); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {   
        $this->validate($request,[ 'idTrabajo'=>'required', 'idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        $existe = Trabajoaspirante::where('idPersona','=',$request['idPersona'])->where('idTrabajo','=',$request['idTrabajo'])->get();
        $success = false;
        if(!count($existe)){
            $success = true;
            Trabajoaspirante::create($request->all()); //Creamos el elemento nuevo
        } 
        return view('trabajoaspirante.show',compact('success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $listaPersonas = Persona::all();
        $listaTrabajos = Trabajo::all();
        $trabajoaspirante=Trabajoaspirante::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('trabajoaspirante.edit',compact('trabajoaspirante'),['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[ 'idTrabajo'=>'required' ,'idPersona'=>'required']); //Validamos los datos antes de actualizar
        Trabajoaspirante::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('trabajoaspirante.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Trabajoaspirante::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('trabajoaspirante.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
