<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Persona;
use App\Localidad;
use App\Provincia;
use App\User;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $personas=Persona::orderBy('idPersona','DESC')->paginate(15);
        return view('Persona.index',compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $provincias=Provincia::all();
        return view('Persona.create',['provincias'=>$provincias]);
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
        $request['idUsuario'] = Auth::user()->idUsuario;                
        $this->validate($request,[ 'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required','idUsuario'=>'required']);
        Persona::create($request->all());
        return redirect()->route('persona.index')->with('success','Registro creado satisfactoriamente');
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
        $personas=Persona::find($id);
        return  view('persona.show',compact('personas'));
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
        $persona=Persona::find($id);
        $provincias=Provincia::all();
        $localidades=Localidad::all();
        return view('Persona.edit',compact('persona'),['provincias'=>$provincias, 'localidades'=>$localidades]);
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
        $this->validate($request,[ 'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required','idUsuario'=>'required']);
        Localidad::find($id)->update($request->all());
        return redirect()->route('persona.index')->with('success','Registro actualizado satisfactoriamente');
    
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
        Persona::find($id)->delete();
        return redirect()->route('persona.index')->with('success','Registro eliminado satisfactoriamente');
   
    }
}
