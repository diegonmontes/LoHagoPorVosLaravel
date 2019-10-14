<?php

namespace App\Http\Controllers;

use App\CategoriaTrabajo;
use App\Trabajo;
use Illuminate\Http\Request;
use Auth;
use App\Persona;
use App\Localidad;
use App\Provincia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Show the form for creating a new resource.
         */
        $listaCategoriaTrabajo=CategoriaTrabajo::all();
        $listaProvincias=Provincia::all();  
        return view('anuncio.index',['provincias'=>$listaProvincias,'listaCategoriaTrabajo'=>$listaCategoriaTrabajo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Seteamo como 'esperando postulaciones'
        $request['idTipoTrabajo'] = 1;
        $titulo=$request->titulo;
        $descripcion=$request->descripcion;
        $controller= new Controller;

        if (isset($request['idPersona'])){ // Significa que ya tenemos el idPersona (viene de flutter)
            $usandoFlutter = true;
        } else { // No tenemos idPersona. Esta en la pc
            $idUsuario = Auth::user()->idUsuario;
            $persona = Persona::where('idUsuario','=',$idUsuario)->get();
            $request['idPersona']=$persona[0]->idPersona;
            $usandoFlutter = false;
        }

        if(isset($request['imagenTrabajo']) && $request['imagenTrabajo']!=null){
            if ($usandoFlutter){ // Significa que el nombre de la img viene por parametro
                $nombreImagen = $request['nombreImagen'];
                $posicion = strrpos($nombreImagen,'.');
                $extension = substr($nombreImagen,$posicion);
                $imagen = base64_decode($request['imagenTrabajo']); // Decodificamos la img
                $request['imagenTrabajo'] = $request['idPersona'].'fotoTrabajo'.date("YmdHms").$extension; // Definimos el nombre
                //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                Storage::disk('trabajo')->put($request['imagenTrabajo'], $imagen);            
            } else { // Significa que esta en laravel, no tenemos el nombre de la img ni su formato
                $imagen=$request->file('imagenTrabajo'); // Obtenemos el obj de la img
                $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
                $nombreImagen = $request['idPersona'].'fotoTrabajo'.date("YmdHms").'.'. $extension;
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                $imagen = File::get($imagen);
                 Storage::disk('trabajo')->put($nombreImagen, $imagen);        
            }
            
            //llamamos a la funcion que valida la imagen
            $validoImagen = $controller->validarImagen($imagen,1);
            
        } else { // Si no carga ninguna imagen, seteamos por defecto el valor a true
            $validoImagen = true;
        }
        $validoTitulo=$controller->moderarTexto($titulo,1); // 1 Significa que evaluamos la variable terms
        sleep(3);
        $validoDescripcion=$controller->moderarTexto($descripcion,1); // 1 Significa que evaluamos la variable terms
        $validoDescripcion=true;
        $errores="";
        if (!($validoTitulo)){
            $errores.="Titulo ";
        }

        if (!($validoDescripcion)){
            $errores.="Descripcion ";
        }

        if (!($validoImagen)){
            $errores.= "Imagen ";
        }


        if ($validoDescripcion && $validoTitulo && $validoImagen){
            $this->validate($request,[ 'titulo'=>'required', 'descripcion'=>'required', 'monto'=>'required']);
            $request['idEstado'] = 1;
            if (Trabajo::create($request->all())){
                if ($usandoFlutter){
                    $respuesta = ['success'=>true];
                } else { // Significa que esta en laravel y debe redireccionar a inicio
                    return redirect()->route('inicio')->with('success','Registro creado satisfactoriamente');
                }
            } else {
                $respuesta = ['success'=>false];
            }
        }else{
            $errores.='con contenido indebido. Por favor cambielo.';
            if ($usandoFlutter){
                $respuesta = ['success'=>false, 'error'=>$errores];
            } else {
                return redirect()->route('inicioasdasd  ')->with('error','Error');
            }
        }

        return response()->json($respuesta);

 
    }

    /*
    * Funcion que lista todos los trabajos y codifica en json para mostrarlo en la aplicacion mobile
    */
    public function buscarTrabajos(){
        $objTrabajo = new Trabajo();
        $listaTrabajos = $objTrabajo->get();
        return json_encode($listaTrabajos);
    }

    /*
    * Buscamos el anuncio segun el id y lo mostramos en ver el anuncio
    */
    public function veranuncio($id){
        $trabajo =  Trabajo::find($id);
        $listaTrabajo = Trabajo::all();
        if(isset($trabajo)){
            return view('anuncio.veranuncio',compact('trabajo'),['listaTrabajo'=>$listaTrabajo]);
        }else{
            return abort(404);
        }
       
    }

    public function buscarTrabajoParam(Request $request){
        $trabajo= Trabajo::where('idTrabajo','=',$request->idTrabajo)->get();
        return json_encode($trabajo);
    }
}

