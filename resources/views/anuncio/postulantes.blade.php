@if(count($listaPostulantes)>0)
<br>
<div class="card">
    <div class="card-header">
      Lista de postulantes
    </div>
    <ul class="list-group list-group-flush">
    @foreach($listaPostulantes as $postulante)
    @php $persona = $postulante->Persona[0] @endphp
    <li class="list-group-item">Apellido y nombre:{{$persona->apellidoPersona}} {{$persona->nombrePersona}} <a class="btn btn-sm align-right btn-success" style="position: absolute;right: 0%;margin-right: 5px;" href="#" postulante="{{$persona->idPersona}}">Elegir</a></li>

    @endforeach
    </ul>
  </div>
    
@endif