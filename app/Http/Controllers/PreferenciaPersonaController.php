<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\CategoriaTrabajo;
use App\PreferenciaPersona;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PreferenciaPersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preferenciasPersona=PreferenciaPersona::orderBy('idPreferenciaPersona','DESC')->paginate(15);
        return view('preferenciapersona.index',compact('preferenciasPersona'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('preferenciapersona.create'); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 'idCategoriaTrabajo'=>'required', 'idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        PreferenciaPersona::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('preferenciapersona.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $preferenciaPersona=PreferenciaPersona::find($id); //Buscamos el elemento para mostrarlo
        return  view('preferenciapersona.show',compact('preferenciaPersona'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $preferenciaPersona=PreferenciaPersona::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('preferenciapersona.edit',compact('preferenciaPersona'));
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
        $this->validate($request,[ 'idCategoriaTrabajo'=>'required' ,'idPersona'=>'required']); //Validamos los datos antes de actualizar
        PreferenciaPersona::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('preferenciapersona.index')->with('success','Registro actualizado satisfactoriamente');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PreferenciaPersona::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('preferenciapersona.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
