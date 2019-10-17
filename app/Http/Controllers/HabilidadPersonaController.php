<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Habilidad;
use App\HabilidadPersona;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HabilidadPersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    $listaPersonas = Persona::all();
    //    $listaHabilidades = Habilidad::all();
    //    return view('habilidadpersona.index',['listaPersonas'=>$listaPersonas,'listaHabilidades'=>$listaHabilidades]);
    $habilidadesPersona=HabilidadPersona::orderBy('idHabilidadPersona','DESC')->paginate(15);
    return view('habilidadpersona.index',compact('habilidadesPersona'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('habilidadpersona.create'); //Vista para crear el elemento nuevo

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 'idHabilidad'=>'required', 'idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        HabilidadPersona::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('habilidadpersona.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $habilidadPersona=HabilidadPersona::find($id); //Buscamos el elemento para mostrarlo
        return  view('habilidadpersona.show',compact('habilidadPersona'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $habilidadPersona=HabilidadPersona::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('habilidadpersona.edit',compact('habilidadPersona'));
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
        $this->validate($request,[ 'idHabilidad'=>'required' ,'idPersona'=>'required']); //Validamos los datos antes de actualizar
        HabilidadPersona::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('habilidadpersona.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HabilidadPersona::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('habilidadpersona.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
