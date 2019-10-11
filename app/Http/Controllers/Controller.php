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



public function moderarTexto($texto){
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
            $respuesta= $response->getBody();
          
            
        }
        catch (HttpException $ex)
        {
            $respuesta=$ex;
        }
        return $respuesta;
}

}
