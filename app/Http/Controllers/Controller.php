<?php

namespace App\Http\Controllers;
use HTTP_Request2;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



public function moderarTexto($texto,$numeroOpcion){

    // 1 evalua tal
    // 2 evalua tal
        $request = new Http_Request2('https://brazilsouth.api.cognitive.microsoft.com/contentmoderator/moderate/v1.0/ProcessText/Screen');
        $url = $request->getUrl();
        $headers = array(
            // Request headers
            'Content-Type' => 'text/plain',
            'Ocp-Apim-Subscription-Key' => 'f598fd509d5945d98f2f3494b27ea1f5',
        );
        $request->setHeader($headers);

        $parameters = array(
            // Request parameters
            'autocorrect' => 'False',
            'PII' => 'True',
            'listId' => '0',
            'classify' => 'True',
            'language' => 'spa',
        );
        $url->setQueryVariables($parameters);
        $request->setMethod(HTTP_Request2::METHOD_POST);
        // Request body
        $request->setBody("$texto");

        try
        {
            $response = $request->send();
            $respuestaAPITextoJson= $response->getBody();
            $respuestaAPITexto = json_decode($respuestaAPITextoJson);
       //     print_r($respuestaAPITexto);
            if ($numeroOpcion==1){
                if($respuestaAPITexto->Terms==null){ // Significa que no hay ninguna mala palabra
                    $respuesta = true;
                }else{ // Significa que no puede ingresar ninguna mala palabra
                    $respuesta= false;
                }
            } elseif ($numeroOpcion==2){
                // va a hacer esto
            }
            
            
        }
        catch (HttpException $ex)
        {
            $respuesta=false;
        }
        return $respuesta;
}
// Valida que la imagen no sea incorrecta
public function validarImagen($imagen,$numeroOpcion){
        // This sample uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
        $imagenCodificada = base64_encode($imagen);

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
        $body = json_encode(array('DataRepresentation' => 'Raw', 'Value' => $imagenCodificada));
        // Request body
        $request->setBody($body);

        try
        {
            $response = $request->send();
            $respuestaAPIJson= $response->getBody();
            $respuestaAPI = json_decode($respuestaAPIJson);
         //   print_R($respuestaAPI);
           
         //   echo $respuestaAPI->IsImageAdultClassified;
            if ($numeroOpcion==1){
                if($respuestaAPI->IsImageAdultClassified==null){ // Significa que la imagen no es indebida
                    $respuesta = true;
                    //echo "todo bien";
                }else{ // Significa que la imagen posee contenido inapropiado 
                    $respuesta= false;
                    //echo "todo mal";
                }
            } elseif ($numeroOpcion==2){
                // va a hacer esto
            }
        }
        catch (HttpException $ex)
        {
            $respuesta = false;
        }
        return $respuesta;
    }



}
