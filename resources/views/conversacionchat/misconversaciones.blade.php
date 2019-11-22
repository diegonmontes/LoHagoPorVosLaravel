@extends('layouts.app')
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
@endsection
@section('content')


<h3 class=" text-center">Mis Conversaciones</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recientes</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat">
            <div class="chat_list active_chat">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>Sunil Rajput <span class="chat_date">Dec 25</span></h5>
                  <p>Test, which is a new approach to have all solutions 
                    astrology under one roof.</p>
                </div>
              </div>
            </div>
            @php
            use App\Http\Controllers\PersonaController;
            use Illuminate\Http\Request;
            @endphp
            @if(count($listaConversaciones)>0)
            
                @foreach ($listaConversaciones as $conversacion)
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
                    <a href="#" onclick="asignarActivo({{$conversacion->idConversacionChat}})" v-on:click="fetchMessages({{$conversacion->idConversacionChat}})">
                    <div class="chat_list" name="divConversacion" id="divConversacion{{$conversacion->idConversacionChat}}">
                        <div class="chat_people">
                            <div class="chat_img"> <img src="{{asset("storage/perfiles/$personaReceptora->imagenPersona")}}" alt="imagen de perfil de {{$personaReceptora ->nombrePersona}} {{$personaReceptora->apellidoPersona}}">  </div>
                                <div class="chat_ib">
                                <h5> {{$personaReceptora->nombrePersona}} {{$personaReceptora->apellidoPersona}} <span class="chat_date">Dec 25</span></h5>
                                <p id="ultimoMensajeConversacion{{$conversacion->idConversacionChat}}">Test, which is a new approach to have all solutions 
                                    astrology under one roof.</p>
                            </div>
                        </div>
                    </div>
                    </a>
                @endforeach 
            @endif

            
          </div>
        </div>
        @php 

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

        
                    <div class="panel panel-default">
                        <div class="panel-heading">Chats</div>

                        <div class="panel-body">
                            <chat-messages :messages="messages"></chat-messages>
                        </div>
                        <input type="hidden" value="" name="idConversacionChat" id="idConversacionChat">
                        <div class="panel-footer">
                            <chat-form
                                v-on:messagesent="addMessage"
                                :persona='@php print_R($persona) @endphp'
                            ></chat-form>
                        </div>
                    </div>
                
      
      
    </div>
    @foreach ($listaConversaciones as $conversacion)
        @php print_R($conversacion->persona1)@endphp
    @endforeach 

@endsection

@section('js')
  <script type="application/javascript">
  function asignarActivo(idConversacion){
    $('#idConversacionChat').val(idConversacion);
    $('.chat_list').removeClass('active_chat'); // Al seleccionado le agregamos el active
    $('#divConversacion'+idConversacion).addClass('active_chat'); // Al seleccionado le agregamos el active
  }
  </script>
@endsection