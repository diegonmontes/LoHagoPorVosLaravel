@extends('layouts.app')

@section('content')
@php 
    use App\Http\Controllers\PersonaController;
    use Illuminate\Http\Request;

    $user = Auth::user();
    $idUsuario = $user->idUsuario;
    $personaController = new PersonaController();
    $paramBuscarPersona = ['idUsuario' => $idUsuario, 'eliminado' => 0];
    $paramBuscarPersona = new Request($paramBuscarPersona);
    $listaPersonas = $personaController->buscar($paramBuscarPersona);
    $listaPersonas = json_decode($listaPersonas);
    $persona = $listaPersonas[0];
    $persona=json_encode($persona);

    

@endphp
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chats</div>

                <div class="panel-body">
                    <chat-messages :messages="messages"></chat-messages>
                </div>
                <div class="panel-footer">
                    <chat-form
                        v-on:messagesent="addMessage"
                        :persona='@php print_R($persona) @endphp'
                    ></chat-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection