<?php

namespace App\Http\Controllers;

use App\TipoTrabajo;
use Illuminate\Http\Request;

class TipoTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tiposDeTrabajo=TipoTrabajo::orderBy('idTipoTrabajo','DESC')->paginate(15);
        return view('TipoTrabajo.index',compact('tiposDeTrabajo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tipoDeTrabajo=TipoTrabajo::find($id);
        return  view('TipoTrabajo.show',compact('tipoDeTrabajo'));
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
        $this->validate($request,[ 'nombreTipo'=>'required']);
        TipoTrabajo::create($request->all());
        return redirect()->route('tipoTrabajo.index')->with('success','Registro creado satisfactoriamente');
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
        $tiposDeTrabajo=TipoTrabajo::find($id);
        return  view('TipoTrabajo.show',compact('tiposDeTrabajo'));
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
        $tipoTrabajo=Localidad::find($id);
        return view('TipoTrabajo.edit',compact('tipoTrabajo'));
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
        $this->validate($request,[ 'nombreTipo'=>'required']);
        TipoTrabajo::find($id)->update($request->all());
        return redirect()->route('tipoTrabajo.index')->with('success','Registro actualizado satisfactoriamente');
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
        TipoTrabajo::find($id)->delete();
        return redirect()->route('tipoTrabajo.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
