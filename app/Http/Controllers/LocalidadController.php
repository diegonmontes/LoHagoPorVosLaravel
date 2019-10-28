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
        $localidades=Localidad::orderBy('idLocalidad','DESC')->paginate(6);
        return view('localidad.index',compact('localidades'));
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
        return view('localidad.create',['provincias'=>$provincias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
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
        return  view('localidad.show',compact('localidades'));
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
        return view('localidad.edit',compact('localidad'),['provincias'=>$provincias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
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

    //Busca todas las localidad segun el id de la provincia
    public function buscar($id){
        return Localidad::where('idProvincia','=',$id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function buscarLocalidades(Request $request){
        $idProvincia = $request['idProvincia'];
        $objLocalidad = new Localidad();
        $listaLocalidades = $objLocalidad->where('idProvincia','=',$idProvincia)->get();
        return json_encode($listaLocalidades);
    }

    // Esta funcion busca todas las localidades con parametros que le enviemos
    public function buscarNuevo($param){      
        $query = Localidad::OrderBy('idLocalidad','ASC'); // Ordenamos las localidades por este medio

            if (isset($param['idLocalidad'])){
                $query->where("localidad.idLocalidad",$param['idLocalidad']);
            }

            if (isset($param['nombreLocalidad'])){
                $query->where("localidad.nombreLocalidad",$param['nombreLocalidad']);
            }

            if (isset($param['idProvincia'])){
                $query->where("localidad.idProvincia",$param['idProvincia']);
            }

            if (isset($param['codigoPostal'])){
                $query->where("localidad.codigoPostal",$param['codigoPostal']);
            }

            $listaLocalidades= $query->get();   // Hacemos el get y seteamos en lista
            return $listaLocalidades;
    }
}
