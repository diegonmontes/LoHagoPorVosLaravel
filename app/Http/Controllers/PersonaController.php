<?php
namespace App\Http\Controllers;

//require_once 'HTTP/Request2.php';

use Faker\Provider\Person;
use HTTP_Request2;
use Illuminate\Http\Request;
use Auth;
use App\Persona;
use App\Localidad;
use App\Provincia;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $personas=Persona::orderBy('idPersona','DESC')->paginate(15);
        return view('persona.index',compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $idUsuario = Auth::user()->idUsuario;
        $laPersona = Persona::where('idUsuario','=',$idUsuario)->get();
        if(count($laPersona)){
            $persona = $laPersona[0];
            $existePersona = true;
        }else{
            $persona = $laPersona;
            $existePersona = false;
        }

        $provincias=Provincia::all();
        return view('persona.create',compact('persona'),['provincias'=>$provincias, 'existePersona'=>$existePersona]);
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
        $controller= new Controller;
        $nombre=$request->nombrePersona;
        $apellido=$request->apellidoPersona;
        if (isset($request['idUsuario'])){ // Significa que ya tenemos el idUsuario (viene de flutter)
            $usandoFlutter = true;
        } else { // No tenemos idUsuario. Esta en la pc
            $idUsuario = Auth::user()->idUsuario;
            $request['idUsuario'] = $idUsuario;
            
            $usandoFlutter = false;
            
        }
       
        if(isset($request['imagenPersona']) && $request['imagenPersona']!=null){
            if ($usandoFlutter){ // Significa que el nombre de la img viene por parametro
                $nombreImagen = $request['nombreImagen'];
                $posicion = strrpos($nombreImagen,'.');
                $extension = substr($nombreImagen,$posicion);
                $imagen = base64_decode($request['imagenPersona']); // Decodificamos la img
                $request['imagenPersona'] = $request['idUsuario'].'fotoPerfil'.date("YmdHms").$extension; // Definimos el nombre
                //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                Storage::disk('perfil')->put($request['imagenPersona'], $imagen);            
            } else { // Significa que esta en laravel, no tenemos el nombre de la img ni su formato
                $imagen=$request->file('imagenPersona'); // Obtenemos el obj de la img
                $extension = $imagen->getClientOriginalExtension(); // Obtenemos la extension
                $nombreImagen = $request['idUsuario'].'fotoPerfil'.date("YmdHms").'.'. $extension;
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                 $imagen = File::get($imagen);
                 Storage::disk('trabajo')->put($nombreImagen, $imagen);       
            }

             // llamamos a la funcion
             $validoImagen = $controller->validarImagen($imagen,1);
        } else { // No carga ninguna imagen
            $validoImagen = true;
        }
        $validoNombre=$controller->moderarTexto($nombre,1); // 1 Significa que evaluamos la variable terms
        sleep(3);
        $validoApellido=$controller->moderarTexto($apellido,1); // 1 Significa que evaluamos la variable terms
        //$validoDescripcion=true;
        $errores="";
        if (!($validoNombre)){
            $errores.="Nombre ";
        }

        if (!($validoApellido)){
            $errores.="Apellido ";
        }

        if (!($validoImagen)){
            $errores.= "Imagen ";
        }


        $this->validate($request,[ 'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required','idUsuario'=>'required']);
        if ($validoImagen && $validoApellido && $validoNombre){
            if (Persona::create($request->all())){
                if ($usandoFlutter){
                    $objPersona = new Persona(); // Creamos el obj persona
                    $persona = $objPersona->where('idUsuario','=',$request['idUsuario'])->get(); //Buscamos el obj persona que tenga ese idusuario
                    $persona = $persona[0]; // Obtenemos obj persona creado recientemente
                    $idPersona = $persona['idPersona']; // Obtenemos id persona
                
                    $respuesta = ['success'=>true,'idPersona'=>$idPersona];
                    return response()->json($respuesta);
                } else { // Significa que esta en laravel y debe redireccionar a inicio
                    return redirect()->route('inicio')->with('success','Registro creado satisfactoriamente');
                }
            } else {
                $respuesta = ['success'=>false];
            }
        }else{
            if ($usandoFlutter){
                $respuesta = ['success'=>false];
            } else {
                return redirect()->route('inicio')->with('error','Error');
            }
        }
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
        $personas=Persona::find($id);
        return  view('persona.show',compact('personas'));
    }

    /**
     * Busca una persona por su id Usuario
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscar($idUsuario)
    {
        $existe=false;
        $objPersona = null;
        $listaPersonas = Persona::where('idUsuario','=',$idUsuario)->get();
        if (count($listaPersonas)>0){
            $objPersona = $listaPersonas[0];
        } else {
            $objPersona=null;
        }
        return $objPersona;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        $idUsuario = Auth::user()->idUsuario;
        $laPersona = Persona::where('idUsuario','=',$idUsuario)->get();
        $persona = $laPersona[1];
        $provincias=Provincia::all();
        $localidades=Localidad::all();
        return view('persona.edit',compact('persona'),['provincias'=>$provincias, 'localidades'=>$localidades]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        //
        $request['idUsuario'] = Auth::user()->idUsuario;
        $laPersona = Persona::where('idUsuario','=',$request['idUsuario'])->get();
        $request['idPersona'] =$laPersona[0]->idPersona;
        $idPersona = $request['idPersona'];
        $this->validate($request,[ 'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required','idUsuario'=>'required','imagenPersona'=>'required']);
        Persona::find($idPersona)->update($request->all());
        $file = $request['archivo'];
        if(isset($file)){
            //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            Storage::disk('local')->put('fotoperfil'.$idPersona, $file);
        }
        return redirect()->route('inicio')->with('success','Registro actualizado satisfactoriamente');

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
        Persona::find($id)->delete();
        return redirect()->route('persona.index')->with('success','Registro eliminado satisfactoriamente');

    }



    
}
