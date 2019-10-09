<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagorecibidoController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pagorecibidos=Pagorecibido::orderBy('idPagoRecibido','DESC')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('pagorecibido.index',compact('pagorecibidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pagorecibido.create'); //Vista para crear el elemento nuevo
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
        $this->validate($request,[ 'monto'=>'required', 'metodo'=>'required', 'tarjeta'=>'required', 'fechapago'=>'required', 'fechaaprobado'=>'required', 'idTrabajo'=>'required', 'idPago'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        Pagorecibido::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('pagorecibido.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $pagorecibidos=Pagorecibido::find($id); //Buscamos el elemento para mostrarlo
        return  view('pagorecibido.show',compact('pagorecibidos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $rol=Pagorecibido::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('pagorecibido.edit',compact('rol'));
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
        $this->validate($request,[ 'monto'=>'required', 'metodo'=>'required', 'tarjeta'=>'required', 'fechapago'=>'required', 'fechaaprobado'=>'required', 'idTrabajo'=>'required', 'idPago'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        Pagorecibido::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('pagorecibido.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Pagorecibido::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('pagorecibido.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
