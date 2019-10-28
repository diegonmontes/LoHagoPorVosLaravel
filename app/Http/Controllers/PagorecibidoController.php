<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pagorecibido;
use App\Trabajo;

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
        $pagoRecibidos=Pagorecibido::orderBy('idPagoRecibido','DESC')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('pagorecibido.index',compact('pagoRecibidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $trabajoController = new TrabajoController();
        $arregloBuscarTrabajos = null;
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        return view('pagorecibido.create',['listaTrabajos'=>$listaTrabajos]); //Vista para crear el elemento nuevo
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
        return redirect()->route('inicio')->with('success','Pago realizado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $pagorecibido=Pagorecibido::find($id); //Buscamos el elemento para mostrarlo
        return  view('pagorecibido.show',compact('pagorecibido'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $trabajoController = new TrabajoController();
        $arregloBuscarTrabajos = null;
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $pagoRecibido=Pagorecibido::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('pagorecibido.edit',compact('pagoRecibido'),['listaTrabajos'=>$listaTrabajos]);
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

    // Esta funcion busca todas los pagos recibidos con parametros que le enviemos
    public function buscar($param){      
        $query = Pagorecibido::OrderBy('idPagoRecibido','ASC'); // Ordenamos los pagos por este medio

            if (isset($param['idPagoRecibido'])){
                $query->where("pagorecibido.idPagoRecibido",$param['idPagoRecibido']);
            }

            if (isset($param['idTrabajo'])){
                $query->where("pagorecibido.idTrabajo",$param['idTrabajo']);
            }

            if (isset($param['idPago'])){
                $query->where("pagorecibido.idPago",$param['idPago']);
            }

            if (isset($param['monto'])){
                $query->where("pagorecibido.monto",$param['monto']);
            }

            if (isset($param['metodo'])){
                $query->where("pagorecibido.metodo",$param['metodo']);
            }

            if (isset($param['tarjeta'])){
                $query->where("pagorecibido.tarjeta",$param['tarjeta']);
            }

            if (isset($param['fechapago'])){
                $query->where("pagorecibido.fechapago",$param['fechapago']);
            }

            if (isset($param['fechaaprobado'])){
                $query->where("pagorecibido.fechaaprobado",$param['fechaaprobado']);
            }

            if (isset($param['eliminado'])){
                $query->where("pagorecibido.eliminado",$param['eliminado']);
            }

            $listaPagos= $query->get();   // Hacemos el get y seteamos en lista
            return $listaPagos;
    }
}
