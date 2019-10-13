<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\CategoriaTrabajo;
use App\Trabajo;
use Illuminate\Http\Request;
use Auth;
use App\Persona;

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
        return view('anuncio.index',['listaCategoriaTrabajo'=>$listaCategoriaTrabajo]);
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
        $this->validate($request,[ 'titulo'=>'required', 'descripcion'=>'required', 'monto'=>'required', 'imagenTrabajo', 'tiempoExpiracion']);
        $request['idTipoTrabajo'] = 1;
        $idUsuario = Auth::user()->idUsuario;
        $persona = Persona::where('idUsuario','=',$idUsuario)->get();
        $request['idPersona']=$persona[0]->idPersona;
        Trabajo::create($request->all());
        return redirect()->route('inicio')->with('success','Registro creado satisfactoriamente');
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeApp(Request $request)
    {
        //
        if(isset($request['imagenTrabajo'])){
            $request['imagenTrabajo'] = base64_decode($request['imagenTrabajo']);
            $file = $request['imagenTrabajo'];
            $nombreImagen = $request['nombreImagen'];
            $posicion = strrpos($nombreImagen,'.');
            $extension = substr($nombreImagen,$posicion);
            $request['imagenTrabajo'] = $request['idPersona'].'fotoTrabajo'.date("YmdHms").$extension;
            //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            Storage::disk('local')->put($request['imagenTrabajo'], $file);
        }
        $this->validate($request,[ 'titulo'=>'required', 'descripcion'=>'required', 'monto'=>'required']);
        $request['idEstado'] = 1;
        if (Trabajo::create($request->all())){
            $respuesta = ['success'=>true];
        } else {
            $respuesta = ['success'=>true];
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

}


// if(!isset($request['idUsuario'])){
//     $request['idUsuario'] = Auth::user()->idUsuario;
// }else{
//     $request['files'] = base64_decode($request['imagenPersona']);
// }

// $request['imagenPersona'] = $request['idUsuario'].'fotoperfil'.date("YmdHms").'.png';
// $this->validate($request,[ 'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required','idUsuario'=>'required', 'imagenPersona'=>'required']);
// Persona::create($request->all());
// $file = $request['files'];
// if(isset($file)){
//     //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
//     Storage::disk('local')->put($request['imagenPersona'], $file);
// }