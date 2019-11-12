@extends('layouts.layout')
@section('css')
<style type="text/css"> 
.card:hover{
    border: 2px #9a3db6 solid;
    -webkit-box-shadow: 0px 0px 10px 0px rgba(154,61,182,1);
-moz-box-shadow: 0px 0px 10px 0px rgba(154,61,182,1);
box-shadow: 0px 0px 10px 0px rgba(154,61,182,1);
}

.card{
    -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
}
</style>
@endsection
@section('content')
<section class="container h-100">
    <div class="row h-100 justify-content-center ">
    @if(count($listaPostulantes)>0)
    <br>
    
    @foreach($listaPostulantes as $postulante)
    @php $persona = $postulante->Persona @endphp

    <form class="col-xs-12 col-sm-12 col-md-6" style="min-width: 100%;min-height: 100%;margin-bottom: 1%;" action="{{route('trabajoasignado.store')}}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="idTrabajo" value="{{$trabajo->idTrabajo}}">
        
            <input type="hidden" name="idPersona" value="{{$persona->idPersona}}">
            <button class="col-xs-12 col-sm-12 col-md-6" type="submit" style="border: none;-moz-appearance: inherit;-o-appearance: inherit;-ms-appearance: inherit;appearance: inherit;-webkit-appearance: inherit;padding: 0%">

    <div class="row col-md-12" style="margin: 0%;padding: 0%">
        <div class="card" style="min-width: 100%;min-height: 100%;">
            
            <div class="row text-left" style="margin:3%">
                <div class="col-xs-7 col-sm-7 col-md-7">
                <h2>{{$persona->apellidoPersona}} {{$persona->nombrePersona}}</h2>
                    <p><strong>Usuario: </strong> {{$persona->Usuario->nombreUsuario}} </p>
                    <p><strong>Localidad: </strong> {{$persona->Localidad->nombreLocalidad}} </p>
                    <p><strong>Habilidades: </strong>
                        @foreach($persona->HabilidadPersona as $unaHabilidadPersona)
                            <span class="tags">{{$unaHabilidadPersona->Habilidad->nombreHabilidad}}</span> 
                        @endforeach
                    </p>
                </div>             
                <div class="col-xs-5 col-sm-5 col-md-5 text-center">
                    <figure>
                            
                        <img style="border-radius: 50%; width: 200px; height: 200px" src="@if($persona->imagenPersona != null){{ asset('storage/perfiles/'.$persona->imagenPersona)}}@else{{asset('images/fotoPerfil.png')}}@endif" alt="" class="img-circle img-responsive">
                        <figcaption class="ratings">
                            <p>
                            @for($i=0;$i<$postulante->valoracion;$i++)
                                <a href="#">
                                    <span class="fa fa-star"></span>
                                </a>
                            @endfor
                            </p>
                        </figcaption>
                    </figure>
                </div>
            </div>
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