<?php

namespace App\Http\Controllers;

use App\CategoriaTrabajo;
use App\Trabajo;
use Illuminate\Http\Request;
use Auth;
use App\Persona;
use App\Http\Controllers\MercadoPagoController;
use App\Localidad;
use App\Provincia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


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
                $request = $request->except('imagenTrabajo'); // Guardamos todo el obj sin la clave imagen trabajo
                $request['imagenTrabajo']=$nombreImagen; // Asignamos de nuevo a imagenTrabajo, su nombre
                $request = new Request($request); // Creamos un obj Request del nuevo request generado anteriormente
                 //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
                $imagen = File::get($imagen);
                Storage::disk('trabajo')->put($nombreImagen, $imagen);        
            }

            //llamamos a la funcion que valida la imagen
            $validoImagen = $controller->validarImagen($imagen,1);
            
        } else { // Si no carga ninguna imagen, seteamos por defecto el valor a true
            $validoImagen = true;
        }
        if($titulo != null){
            $validoTitulo=$controller->moderarTexto($titulo,1); // 1 Significa que evaluamos la variable terms
        }else{
            $validoTitulo = true;
        }
        sleep(3);
        if($descripcion != null){
            $validoDescripcion=$controller->moderarTexto($descripcion,1); // 1 Significa que evaluamos la variable terms
        }else{
            $validoDescripcion = true;
        }
        
            //$validoDescripcion=true;
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

        if($usandoFlutter){
            if(isset($request['horaSeleccionada']) && isset($request['diaSeleccionado'])){ // Si estan seteados estos valores es porque esta en flutter. hay que editar la fecha
                $horaSinEditar = $request['horaSeleccionada']; // Obtenemos la hs sin editar
                $diaSinEditar = $request['diaSeleccionado']; // El dia que selecciono sin editar
                $diaEditado = substr($diaSinEditar,0,10);
                $horaEditada = substr($horaSinEditar,10,5); // Eliminamos los milisegundos que vienen del timepicker
                $request['tiempoExpiracion'] = $diaEditado.' '.$horaEditada; // concatenamos y seteamos
            }
        }


        if ($validoDescripcion && $validoTitulo && $validoImagen){
            $mensajesErrores =[             
                'titulo.required' => 'El titulo es obligatorio.',
                'titulo.max' => 'Maximo de palabras sobrepasado.',
                'descripcion.required' => 'La descripcion es obligatorio.',
                'descripcion.max' => 'Maximo de palabras sobrepasado.',
                'monto.required' => 'El monto es obligatorio.',
                'monto.numeric' => 'Solamente se puede ingresar numeros.',
                'tiempoExpiracion.required' => 'La fecha de expiracion es obligatorio'
            ] ;

            //Validaciones del trabajo
            $this->validate($request,[ 'titulo'=>'required|max:255', 'descripcion'=>'required|max:511', 'monto'=>'required|numeric','tiempoExpiracion'=>'required','imagenTrabajo' =>'nullable:true'],$mensajesErrores);
            $request['idEstado'] = 1;
            if (Trabajo::create($request->all())){
                if ($usandoFlutter){
                    $respuesta = ['success'=>true];
                } else { // Significa que esta en laravel y debe redireccionar a inicio
                    return response()->json([
                        'url' => route('inicio'),
                        'success'   => true,
                        'message'   => 'Los datos se han guardado correctamente.' //Se recibe en la seccion "success", data.message
                        ], 200);
                    //return redirect()->route('inicio')->with('success','Registro creado satisfactoriamente');
                }
            } else {
                $respuesta = ['success'=>false];
            }
        }else{
            $errores.='con contenido indebido. Por favor cambielo.';
            if ($usandoFlutter){
                $respuesta = ['success'=>false, 'error'=>$errores];
            } else {
                return response()->json([
                    'success'   => false,
                    'errors'   => ['valido' => [0 => $errores ]] //Se recibe en la seccion "success", data.message
                    ], 422);
                //return redirect()->route('trabajo.index')->with('success',$errores);
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
        //Buscamosel trabajo por el id para mistrar
        $trabajo =  Trabajo::find($id);

        if($trabajo->imagenTrabajo == null){
            $objetoCategoriaTrabajo = new CategoriaTrabajo;
            //Buscamos el objeto de categoria trabajo
            $categoriaTrabajo = $objetoCategoriaTrabajo->find($trabajo->idCategoriaTrabajo);
            $trabajo['imagenCategoria'] = $categoriaTrabajo->imagenCategoriaTrabajo;
        }

        //Seteamos los valores para crear el modelo de MP y obtener el link de pago
        $monto = $trabajo['monto'];
        $titulo = $trabajo['titulo'];
        $idTrabajo = $trabajo['idTrabajo'];
        $arregloTrabajo = ['monto'=>$monto,'titulo'=>$titulo,'idTrabajo'=>$idTrabajo];
        $requestTrabajo = new Request($arregloTrabajo);
        $MPController = new MercadoPagoController();
        $link = $MPController->crearPago($requestTrabajo);

        //Listamos los trabajos para mostrar en un carousel
        $listaTrabajo = Trabajo::all();

        if(isset($trabajo)){
            return view('anuncio.veranuncio',compact('trabajo'),['listaTrabajo'=>$listaTrabajo,'link'=>$link]);
        }else{
            return abort(404);
        }
       
    }

    public function procesarPago(){
        return view('anuncio.procesarpago');
    }

    public function buscarTrabajoParam(Request $request){
        $trabajo= Trabajo::where('idTrabajo','=',$request->idTrabajo)->get();
        return json_encode($trabajo);
    }
}

