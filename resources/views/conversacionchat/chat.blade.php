@extends('layouts.conversacion')
@section('css')
<style>

.container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}

.circuloNotificacion {
     width: 15px;
     height: 15px;
     -moz-border-radius: 50%;
     -webkit-border-radius: 50%;
     border-radius: 50%;
     background: #5cb85c;
     margin-left:10px;
}

.mensajeSinLeer {
  font-weight:bold;
  color:#000 !important;
}

.mensajeDerecha {
  float: right;
}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
</style>
    <style>
        .chat {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .chat li {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #B3A9A9;
        }

        .chat li .chat-body p {
            margin: 0;
            color: #777777;
        }

        .panel-body {
            overflow-y: scroll;
            height: 350px;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        ::-webkit-scrollbar-thumb {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
            background-color: #555;
        }
    </style>
@endsection
@section('content')
<div id="app">

<h3 class=" text-center">Mis Conversaciones</h3>
            
            @php
           
            @endphp
            {{-- @if(count($conversacion)>0)
            
                @foreach ($conversacion as $conversacion)
                    @php

                    $idUsuario = Auth::user()->idUsuario;
                    //Con el idUsuario buscamos la persona
                    $controlPersona = new PersonaController;
                    $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
                    $param = new Request($param);
                    $personaLogeada = $controlPersona->buscar($param);
                    $personaLogeada = json_decode($personaLogeada);
                    $personaLogeada = $personaLogeada[0];
                    $personaEmisora = $personaLogeada;                    
                    if ($conversacion->persona1->idPersona == $personaLogeada->idPersona){ // si esta bien significa que el logeado esta en la bd como persona 1
                        $personaReceptora = $conversacion->persona2; // asignamos como receptora a la persona 2
                    } else { // Si no significa que es la persona 2
                        $personaReceptora = $conversacion->persona1;                 // asignamos como repectora la persona 1       
                    }

                    //persona emisora y persona a
                    @endphp
                    <a href="#" v-on:click="fetchMessages({{$conversacion->idConversacionChat}},{{$personaLogeada->idPersona}})">
                    <div class="chat_list" name="divConversacion" id="divConversacion{{$conversacion->idConversacionChat}}">
                        <div class="chat_people">
                            <div class="chat_img"> <img src="{{asset("storage/perfiles/$personaReceptora->imagenPersona")}}" alt="imagen de perfil de {{$personaReceptora ->nombrePersona}} {{$personaReceptora->apellidoPersona}}">  </div>
                                <div class="chat_ib">
                                <h5> {{$personaReceptora->nombrePersona}} {{$personaReceptora->apellidoPersona}} <span name="notificacionConversacion{{$conversacion->idConversacionChat}}" id="notificacionConversacion{{$conversacion->idConversacionChat}}" @if((!$conversacion->ultimoMensaje->visto) && $conversacion->ultimoMensaje->idPersona != $personaEmisora->idPersona) class="circuloNotificacion" @endif> </span> <span class="chat_date">{{$conversacion->ultimoMensaje->created_at}}</span></h5>
                                <p id="ultimoMensajeConversacion{{$conversacion->idConversacionChat}}" @if((!$conversacion->ultimoMensaje->visto) && $conversacion->ultimoMensaje->idPersona != $personaEmisora->idPersona) class="mensajeSinLeer" @endif >
                                  {{$conversacion->ultimoMensaje->mensaje}}
                                </p>
                            </div>
                        </div>
                    </div>
                    </a>
                @endforeach 
            @endif

            
          </div>
        </div>--}}
        @php
            use App\Http\Controllers\PersonaController;
            use Illuminate\Http\Request;
            @endphp
            
                    @php

                    $idUsuario = Auth::user()->idUsuario;
                    //Con el idUsuario buscamos la persona
                    $controlPersona = new PersonaController;
                    $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
                    $param = new Request($param);
                    $personaLogeada = $controlPersona->buscar($param);
                    $personaLogeada = json_decode($personaLogeada);
                    $personaLogeada = $personaLogeada[0];
                    $personaEmisora = $personaLogeada;                    
                    if ($conversacion->persona1->idPersona == $personaLogeada->idPersona){ // si esta bien significa que el logeado esta en la bd como persona 1
                        $personaReceptora = $conversacion->persona2; // asignamos como receptora a la persona 2
                    } else { // Si no significa que es la persona 2
                        $personaReceptora = $conversacion->persona1;                 // asignamos como repectora la persona 1       
                    }

                    //persona emisora y persona a
                    @endphp
                    <div class="chat_list" name="divConversacion" id="divConversacion{{$conversacion->idConversacionChat}}">
                        <div class="chat_people">
                            <div class="chat_img"> <img src="{{asset("storage/perfiles/$personaReceptora->imagenPersona")}}" alt="imagen de perfil de {{$personaReceptora ->nombrePersona}} {{$personaReceptora->apellidoPersona}}">  </div>
                                <div class="chat_ib">
                                
                            </div>
                        </div>
                    </div>
        @php 
            // use App\Http\Controllers\PersonaController;
            // use Illuminate\Http\Request;
            $user = Auth::user();
            $idUsuario = $user->idUsuario;
            $personaController = new PersonaController();
            $paramBuscarPersona = ['idUsuario' => $idUsuario, 'eliminado' => 0];
            $paramBuscarPersona = new Request($paramBuscarPersona);
            $listaPersonas = $personaController->buscar($paramBuscarPersona);
            $listaPersonas = json_decode($listaPersonas);
            $persona = $listaPersonas[0];
            $idPersona = $persona->idPersona;
            $persona = json_encode($persona);

           
           
        @endphp 

                    <div class="panel panel-default" v-on="fetchMessages({{$conversacion->idConversacionChat}},@php echo $idPersona @endphp)" name="divConversacion" id="divConversacion{{$conversacion->idConversacionChat}}">
                        <div class="panel-heading">Chats</div>

                        <div class="panel-body">
                            <chat-messages :messages="messages"></chat-messages>
                        </div>
                      <input type="hidden" id="idPersonaLogeada" name="idPersonaLogeada" value="@php echo $idPersona @endphp">
                        <input type="hidden" value="1" name="idConversacionChat" id="idConversacionChat">
                        <div class="panel-footer">
                            <chat-form
                                v-on:messagesent="addMessage"
                                :persona='@php print_R($persona) @endphp'
                            ></chat-form>
                        </div>
                    </div>
                

@endsection