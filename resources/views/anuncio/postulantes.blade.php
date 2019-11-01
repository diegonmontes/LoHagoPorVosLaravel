@extends('layouts.layout')

@section('content')
<section class="container h-100">
    <div class="row h-100 justify-content-center ">
    @if(count($listaPostulantes)>0)
    <br>

    @foreach($listaPostulantes as $postulante)
    @php $persona = $postulante->Persona[0] @endphp

    <form action="{{route('trabajoasignado.store')}}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="idTrabajo" value="{{$trabajo->idTrabajo}}">
        
            <input type="hidden" name="idPersona" value="{{$persona->idPersona}}">
            <button type="submit" style="border: none;-moz-appearance: inherit;-o-appearance: inherit;-ms-appearance: inherit;appearance: inherit;-webkit-appearance: inherit;">

    <div class="row col-md-12" style="margin-bottom: 1%;">
        <div class="card" style="min-width: 100%;min-height: 100%;">
            <ul class="list-group list-group-flush">
            
            <div class="row" style="margin:3%">
                <div class="col-xs-8 col-sm-8 col-md-8">
                <h2>{{$persona->apellidoPersona}} {{$persona->nombrePersona}}</h2>
                    <p><strong>Usuario: </strong> {{$persona->User->nombreUsuario}} </p>
                    <p><strong>Localidad: </strong> {{$persona->Localidad->nombreLocalidad}} </p>
                    <p><strong>Habilidades: </strong>
                        @foreach($persona->HabilidadPersona as $unaHabilidadPersona)
                            <span class="tags">{{$unaHabilidadPersona->Habilidad->nombreHabilidad}}</span> 
                        @endforeach
                    </p>
                </div>             
                <div class="col-xs-4 col-sm-4 col-md-4 text-center">
                    <figure>
                            
                        <img style="border-radius: 50%; width: 200px; height: 200px" src="@if($persona->imagenPersona != null){{ asset('storage/perfiles/'.$persona->imagenPersona)}}@else{{asset('images/fotoPerfil.png')}}@endif" alt="" class="img-circle img-responsive">
                        <figcaption class="ratings">
                            <p>Calificación
                            <a href="#">
                                <span class="fa fa-star"></span>
                            </a>
                            <a href="#">
                                <span class="fa fa-star"></span>
                            </a>
                            <a href="#">
                                <span class="fa fa-star"></span>
                            </a>
                            <a href="#">
                                <span class="fa fa-star"></span>
                            </a>
                            <a href="#">
                                <span class="fa fa-star-o"></span>
                            </a> 
                            </p>
                        </figcaption>
                    </figure>
                </div>
            </div>


           
            
                

            </ul>
        </div>
    </div>
</button>
</form>
    @endforeach

    @endif
    </div>
</section>


@endsection

@section('js')
<script>

function eleccionPostulante(){
    console.log('hola');
}

</script>

@endsection