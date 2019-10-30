<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;

class ProvinciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $provincias=Provincia::orderBy('idProvincia','DESC')->paginate(15);
        return view('provincia.index',compact('provincias')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('provincia.create');
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
        $this->validate($request,[ 'nombreProvincia'=>'required', 'codigoIso31662'=>'required']);
        Provincia::create($request->all());
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
        $provincias=Provincia::find($id);
        return  view('provincia.show',compact('provincias'));
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
        $provincia=Provincia::find($id);
        return view('provincia.edit',compact('provincia'));
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
        $this->validate($request,[ 'nombreProvincia'=>'required', 'codigoIso31662'=>'required']);
        Provincia::find($id)->update($request->all());
        return redirect()->route('provincia.index')->with('success','Registro actualizado satisfactoriamente');
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
        Provincia::find($id)->delete();
        return redirect()->route('provincia.index')->with('success','Registro eliminado satisfactoriamente');
    }

    public function buscarProvincias(){
        $objProvincia = new Provincia();
        $listaProvincias = $objProvincia->get();
        return json_encode($listaProvincias);
    }

    // Esta funcion busca todas las provincias con parametros que le enviemos
    public function buscar(Request $param){      
        $query = Provincia::OrderBy('idProvincia','ASC'); // Ordenamos las provincias por este medio

            if (isset($param->idProvincia)){
                $query->where("provincia.idProvincia",$param->idProvincia);
            }

            if (isset($param->nombreProvincia)){
                $query->where("provincia.nombreProvincia",$param->nombreProvincia);
            }

            if (isset($param->codigoIso31662)){
                $query->where("provincia.codigoIso31662",$param->codigoIso31662);
            }

            $listaProvincias= $query->get();   // Hacemos el get y seteamos en lista
            return $listaProvincias;
    }


}
