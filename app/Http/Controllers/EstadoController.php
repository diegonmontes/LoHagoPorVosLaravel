<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;

class EstadoController extends Controller
{
    /* Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
       //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
       $estados=Estado::orderBy('idEstado','ASC')->where('eliminado','0')->paginate(15);
       return view('estado.index',compact('estados'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create()
   {
       //Vista para crear el elemento nuevo
       return view('estado.create'); 
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
       //Validamos los datos antes de guardar el elemento nuevo
       $this->validate($request,[ 'nombreEstado'=>'required', 'descripcionEstado'=>'required']);
       //Creamos el elemento nuevo
       Estado::create($request->all()); 
       return redirect()->route('estado.index')->with('success','Registro creado satisfactoriamente');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
       $estados=Estado::find($id); //Buscamos el elemento para mostrarlo
       return  view('estado.show',compact('estados'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function edit($id)
   {
       //Buscamos el elemento para cargarlo en la vista para luego editarlo
       $estado=Estado::find($id);
       return view('estado.edit',compact('estado'));
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
        //Validamos los datos antes de guardar el elemento nuevo
       $this->validate($request,[ 'nombreEstado'=>'required', 'descripcionEstado'=>'required']);
       //Actualizamos el elemento con los datos nuevos
       Estado::find($id)->update($request->all()); 
       return redirect()->route('estado.index')->with('success','Registro actualizado satisfactoriamente');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
       // Actualizamos eliminado a 1 (Borrado lógico)
       Estado::where('idEstado',$id)->update(['eliminado'=>1,'updated_at'=>now()]);
       //Buscamos y eliminamos el elemento
       //Estado::find($id)->delete(); 
       return redirect()->route('estado.index')->with('success','Registro eliminado satisfactoriamente');
   }

   // Esta funcion busca todas los estados con parametros que le enviemos
   public function buscar(Request $param){      
        $query = Estado::OrderBy('idEstado','DESC'); // Ordenamos los estados por este medio

        if (isset($param->idEstado)){
            $query->where("estado.idEstado",$param->idEstado);
        }

        if (isset($param->nombreEstado)){
            $query->where("estado.nombreEstado",$param->nombreEstado);
        }

        if (isset($param->descripcionEstado)){
            $query->where("estado.descripcionEstado",$param->descripcionEstado);
        }

        if (isset($param->eliminado)){
            $query->where("estado.eliminado",$param->eliminado);
        }

        $listaEstados= $query->get();   // Hacemos el get y seteamos en lista
        return json_encode($listaEstados);
    }


}
