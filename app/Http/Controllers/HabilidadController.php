<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Habilidad;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HabilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->rolesAutorizados([1]);
        $habilidades=Habilidad::orderBy('idHabilidad','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('habilidad.index',compact('habilidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->rolesAutorizados([1]);
        return view('habilidad.create'); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->rolesAutorizados([1]);
        $this->validate($request,[ 'nombreHabilidad'=>'required', 'descripcionHabilidad'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        
        if(isset($request['imagenHabilidad']) && $request['imagenHabilidad']!=null){
            $imagen=$request->file('imagenHabilidad'); // Obtenemos el obj de la img
         //   print_R($request['imagenHabilidad']);
         //   die();
            $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
            $nombreImagen ='imagenHabilidad-'.date("YmdHms").'.'. $extension;
            $request = $request->except('imagenHabilidad'); // Guardamos todo el obj sin la clave imagen trabajo
            $request['imagenHabilidad']=$nombreImagen; // Asignamos de nuevo a imagenTrabajo, su nombre
            $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
             //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            $imagen = File::get($imagen);
            Storage::disk('habilidad')->put($nombreImagen, $imagen);    
        }
        
         
        Habilidad::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('habilidad.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $habilidades=Habilidad::find($id); //Buscamos el elemento para mostrarlo
        return  view('habilidad.show',compact('habilidades'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::user()->rolesAutorizados([1]);
        $habilidad=Habilidad::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('habilidad.edit',compact('habilidad'));
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
        $this->validate($request,[ 'nombreHabilidad'=>'required' ,'descripcionHabilidad'=>'required']); //Validamos los datos antes de actualizar
        if(isset($request['imagenHabilidad']) && $request['imagenHabilidad']!=null){
            $imagen=$request->file('imagenHabilidad'); // Obtenemos el obj de la img
            $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
            $nombreImagen ='imagenHabilidad-'.date("YmdHms").'.'. $extension;
            $request = $request->except('imagenHabilidad'); // Guardamos todo el obj sin la clave imagen trabajo
            $request['imagenHabilidad']=$nombreImagen; // Asignamos de nuevo a imagenTrabajo, su nombre
            $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
             //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            $imagen = File::get($imagen);
            Storage::disk('habilidad')->put($nombreImagen, $imagen);    
        }
        
        Habilidad::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('habilidad.index')->with('success','Registro actualizado satisfactoriamente');
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
        Habilidad::where('idHabilidad',$id)->update(['eliminado'=>1]);
        //Habilidad::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('habilidad.index')->with('success','Registro eliminado satisfactoriamente');
    }

    public function buscarHabilidades(){
        $objHabilidad = new Habilidad();
        $listaHabilidades = $objHabilidad->get();
        return json_encode($listaHabilidades);
    }

    // Esta funcion busca todas las habilidades con parametros que le enviemos
    public function buscar(Request $param){      
        $query = Habilidad::OrderBy('idHabilidad','ASC'); // Ordenamos las habilidades por este medio

            if (isset($param->nombreHabilidad)){
                $query->where("habilidad.nombreHabilidad",$param->nombreHabilidad);
            }

            if (isset($param->descripcionHabilidad)){
                $query->where("habilidad.descripcionHabilidad",$param->descripcionHabilidad);
            }

            if (isset($param->imagenHabilidad)){
                $query->where("habilidad.imagenHabilidad",$param->imagenHabilidad);
            }

            if (isset($param->idHabilidad)){
                    $query->where("habilidad.idHabilidad",$param->idHabilidad);
            }

            if (isset($param->eliminado)){
                $query->where("habilidad.eliminado",$param->eliminado);
            }

         
            $listaHabilidades= $query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaHabilidades);
    }

}
