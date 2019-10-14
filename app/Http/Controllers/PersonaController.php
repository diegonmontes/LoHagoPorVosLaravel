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
        return view('Persona.index',compact('personas'));
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
        return view('Persona.create',compact('persona'),['provincias'=>$provincias, 'existePersona'=>$existePersona]);
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
                Storage::disk('perfil')->put($nombreImagen, File::get($imagen));        
            }
             //Aca deberiamos validar la imagen

             // llamamos a la funcion
             $imagenValida = true;
        } else { // No carga ninguna imagen
            $imagenValida = true;
        }



        $this->validate($request,[ 'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required','idUsuario'=>'required']);
        if ($imagenValida){
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
        return view('Persona.edit',compact('persona'),['provincias'=>$provincias, 'localidades'=>$localidades]);
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



    public function validarImagen($imagen)
    {
        // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)

        $request = new Http_Request2('https://brazilsouth.api.cognitive.microsoft.com/contentmoderator/moderate/v1.0/ProcessImage/Evaluate');
        //$url = $request->getUrl();
        $imageUrl =  'https://reviewcontentstoragebrs.blob.core.windows.net/lohagoporvos/IMG_201910ie9555109d0fe4c1bb7648056347665d8?sv=2015-12-11&sr=c&sig=kF9npeNpI%2FSrbdBIiK9to4xuxLM%2FbLunSn8%2F8tTRyS0%3D&se=2019-10-10T22%3A59%3A27Z&sp=r';
        
        $headers = array(
            // Request headers
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => 'f598fd509d5945d98f2f3494b27ea1f5',
        );

        $request->setHeader($headers);

        $parameters = array(
            // Request parameters
            'CacheImage' => 'false',
        );

        $url->setQueryVariables($parameters);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body
        $request->setBody("{body}");

        try
        {
            $response = $request->send();
            $valido = $response->getBody();
        }
        catch (HttpException $ex)
        {
            $valido = $ex;
        }
        return $valido;
    }


}
