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
        $file = $request['file'];
        if(!isset($request['idUsuario'])){
            $request['idUsuario'] = Auth::user()->idUsuario;
        }else{
            $request['files'] = base64_decode($request['imagenPersona']);
        }
        //print_r($_GET['files']);
        //$img = base64_encode($request['files'][0]);
        //$posicion = strrpos($img,',');
        //$img = substr($img,$posicion+1);
        // $path = 'http://localhost/LoHagoPorVosLaravel/public/images/logoLoHagoPorVosNavar.png';
        // $data = file_get_contents($path);
        // $img = base64_encode($data);
        // $imagenValida =  PersonaController::validarImagen($img);
        $request['imagenPersona'] = $request['idUsuario'].'fotoperfil'.date("YmdHms").'.jpg';

        $this->validate($request,[ 'nombrePersona'=>'required','apellidoPersona'=>'required','dniPersona'=>'required','telefonoPersona'=>'required','idLocalidad'=>'required','idUsuario'=>'required', 'imagenPersona'=>'required']);

        //Persona::create($request->all());
        
        print_r($file);
        dd($file);
        die();
        //if(isset($file)){
            //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
            Storage::disk('perfil')->put('hola.jpg',File::get($file));
        //}

        return redirect()->route('inicio')->with('success','Registro creado satisfactoriamente');
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



    public function validarImagen($img)
    {

        // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)

        //$url = $request->getUrl();
        $uriBase = 'https://brazilsouth.api.cognitive.microsoft.com/contentmoderator/moderate/v1.0/ProcessImage/Evaluate';


        $request = new Http_Request2($uriBase);
        $url = $request->getUrl();
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

        // Request body parameters
        $body = json_encode(array('DataRepresentation' => 'Raw', 'Value' => $img));

        // Request body
        $request->setBody($body);

        try
        {
            $response = $request->send();
            $valido = json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT);
        }
        catch (HttpException $ex)
        {
            $valido = $ex;

        }

        return $valido;
    }


}
