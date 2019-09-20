<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Localidad;
use App\Provincia;

class LocalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $localidades=Localidad::orderBy('idLocalidad','DESC')->paginate(15);
        return view('Localidad.index',compact('localidades'));
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
        return view('Localidad.create',['provincias'=>$provincias]);
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
        $this->validate($request,[ 'nombreLocalidad'=>'required','idProvincia'=>'required','codigoPostal'=>'required']);
        Localidad::create($request->all());
        return redirect()->route('localidad.index')->with('success','Registro creado satisfactoriamente');
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
        $localidades=Localidad::find($id);
        return  view('Localidad.show',compact('localidades'));
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
        $localidad=Localidad::find($id);
        $provincias=Provincia::all();
        return view('Localidad.edit',compact('localidad'),['provincias'=>$provincias]);
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
        $this->validate($request,[ 'nombreLocalidad'=>'required','idProvincia'=>'required', 'codigoPostal'=>'required']);
        Localidad::find($id)->update($request->all());
        return redirect()->route('localidad.index')->with('success','Registro actualizado satisfactoriamente');
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
        Localidad::find($id)->delete();
        return redirect()->route('localidad.index')->with('success','Registro eliminado satisfactoriamente');
    }

    public function buscar($id){
        return Localidad::where('idProvincia','=',$id)->get();
    }
}
