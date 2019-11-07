<?php

namespace App\Http\Controllers;

use App\CategoriaTrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class CategoriaTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categoriasTrabajo=CategoriaTrabajo::orderBy('idCategoriaTrabajo','ASC')->where('eliminado','0')->paginate(10);
        return view('categoriatrabajo.index',compact('categoriasTrabajo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('categoriatrabajo.create');
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
       
        $this->validate($request,[ 'nombreCategoriaTrabajo'=>'required','descripcionCategoriaTrabajo'=>'required']);
        if(isset($request['imagenCategoriaTrabajo']) && $request['imagenCategoriaTrabajo']!=null){
            $imagen=$request->file('imagenCategoriaTrabajo'); // Obtenemos el obj de la img
            $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
            $nombreImagen ='imagenCategoriaTrabajo-'.date("YmdHms").'.'. $extension;
            $request = $request->except('imagenCategoriaTrabajo'); // Guardamos todo el obj sin la clave imagen trabajo
            $request['imagenCategoriaTrabajo']=$nombreImagen; // Asignamos de nuevo a imagenTrabajo, su nombre
            $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
             //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            $imagen = File::get($imagen);
            Storage::disk('trabajo')->put($nombreImagen, $imagen);    
        }
        CategoriaTrabajo::create($request->all());
        return redirect()->route('categoriatrabajo.index')->with('success','Registro creado satisfactoriamente');
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
        $categoriasTrabajo=CategoriaTrabajo::find($id);
        return  view('categoriatrabajo.show',compact('categoriasTrabajo'));
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
        $categoriaTrabajo=CategoriaTrabajo::find($id);//Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('categoriatrabajo.edit',compact('categoriaTrabajo'));
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
        $this->validate($request,[ 'nombreCategoriaTrabajo'=>'required','descripcionCategoriaTrabajo'=>'required']);
        if(isset($request['imagenCategoriaTrabajo']) && $request['imagenCategoriaTrabajo']!=null){
            $imagen=$request->file('imagenCategoriaTrabajo'); // Obtenemos el obj de la img
            $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
            $nombreImagen ='imagenCategoriaTrabajo-'.date("YmdHms").'.'. $extension;
            $request = $request->except('imagenCategoriaTrabajo'); // Guardamos todo el obj sin la clave imagen trabajo
            $request['imagenCategoriaTrabajo']=$nombreImagen; // Asignamos de nuevo a imagenTrabajo, su nombre
            $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
             //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            $imagen = File::get($imagen);
            Storage::disk('trabajo')->put($nombreImagen, $imagen);    
        }
        
        CategoriaTrabajo::find($id)->update($request->all());
        return redirect()->route('categoriatrabajo.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Actualizamos eliminado a 1 (Borrado lógico)
        CategoriaTrabajo::where('idCategoriaTrabajo',$id)->update(['eliminado'=>1]);
        //Buscamos y eliminamos el elemento
        //CategoriaTrabajo::find($id)->delete();
        return redirect()->route('categoriatrabajo.index')->with('success','Registro eliminado satisfactoriamente');
    }

    public function buscarCategorias(){
        $objCategoriaTrabajo = new CategoriaTrabajo();
        $listaCategorias = $objCategoriaTrabajo->get();
        return json_encode($listaCategorias);
    }

    // Esta funcion busca todas las categorias de trabajo con parametros que le enviemos
    public function buscar(Request $param){      
        $query = CategoriaTrabajo::OrderBy('idCategoriaTrabajo','ASC'); // Ordenamos las categorias por este medio

            if (isset($param->idCategoriaTrabajo)){
                $query->where("categoriaTrabajo.idCategoriaTrabajo",$param->idCategoriaTrabajo);
            }

            if (isset($param->nombreCategoriaTrabajo)){
                $query->where("categoriaTrabajo.nombreCategoriaTrabajo",$param->nombreCategoriaTrabajo);
            }

            if (isset($param->descripcionCategoriaTrabajo)){
                $query->where("categoriaTrabajo.descripcionCategoriaTrabajo",$param->descripcionCategoriaTrabajo);
            }

            if (isset($param->imagenCategoriaTrabajo)){
                $query->where("categoriaTrabajo.imagenCategoriaTrabajo",$param->imagenCategoriaTrabajo);
            }

            if (isset($param->eliminado)){
                $query->where("categoriaTrabajo.eliminado",$param->eliminado);
            }

            $listaCategorias= $query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaCategorias);
    }
}
