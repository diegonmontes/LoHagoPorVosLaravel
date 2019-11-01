
@extends('layouts.layout')
@section('content')
<section class="container h-100">
    <div class="row h-100 justify-content-center ">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="card-title">{{$trabajo->titulo}}</h5>
                </div>
                @if(!$trabajo->imagenTrabajo)
                    @php $nombreImagen = $trabajo->CategoriaTrabajo->imagenCategoriaTrabajo @endphp
                    <img src="{{ asset("storage/trabajos/$nombreImagen")}}">
                @else 
                    <img src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}">
                @endif
                <div class="card-body">
                    <p class="card-text">{{$trabajo->descripcion}}</p>
                </div>

            </div>



            @include('comentario.list', ['comentarios' => $trabajo->Comentarios])            
            @include('comentario.form')
        </div>

        <div class="col-md-2" >
            <div class="card">
                <ul class="list-group list-group-flush" style="width:15rem">
                    <li class="list-group-item">{{$trabajo->titulo}}</li>
                    <li class="list-group-item">${{$trabajo->monto}}</li>
                    
                        @if(count($personaAsignada)>0)
                            @php
                            if (!$pagado){ // Si ya se pago este anuncio
                                $link = json_decode($link); // Decodificamos el link recibido para obtener el smart checkout
                                # Return the HTML code for button
                                echo "<a class='btn btn-success btn-sm' href=$link> Pagar </a>";
                            }
                            @endphp
                        @else

                            <button class='btn btn-success btn-sm' onClick="mostrarModal()" > Elegir un postulante </button>
                        @endif
                   

                    {{-- Si ya se postulo no mostramos boton postularse --}}
                    @if(!$tienePostulacion) 
                    <li class="list-group-item"><a href="{{route ('postularme',$trabajo->idTrabajo)}}" class="btn btn-success btn-sm">Postularme</a></li>
                    @endif    


                    
                    
                    
                </ul>
            </div>
        </div>
    </div>


      <div id="modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Lista de postulantes</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                @include('anuncio.postulantes',['listaPostulantes'=>$listaPostulantes])

            </div>
           
          </div>
        </div>
      </div>
</section>
<script >

function mostrarModal(){
    $('#modal').show();
}
    </script>

{{-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="margin: auto;">
        <div class="carousel-inner">
            @php $cant = 0 @endphp
            <div class="carousel-item active">
                <div class="row">
                    @foreach($listaTrabajo as $trabajo)
                        @if($cant<4)
                            <div class="card" style="width: 18rem; margin-left: 1%; margin-right: 1%; margin-top: 1%;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$trabajo->titulo}}</h5>
                                    <p class="card-text">{{$trabajo->descripcion}}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{route ('veranuncio',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                                    <label class="product_price float-right">${{$trabajo->monto}}</label>
                                </div>
                            </div>
                        @endif
                        @php $cant = $cant + 1 @endphp
                    @endforeach

                </div>
            </div>
            @php $cant = 4 @endphp
            <div class="carousel-item">
                    <div class="row">
                        @foreach($listaTrabajo as $trabajo)
                            @if($cant>4 && $cant<8)
                                <div class="card" style="width: 18rem; margin-left: 1%; margin-right: 1%; margin-top: 1%;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$trabajo->titulo}}</h5>
                                        <p class="card-text">{{$trabajo->descripcion}}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{route ('veranuncio',$trabajo->idTrabajo)}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                                        <label class="product_price float-right">${{$trabajo->monto}}</label>
                                    </div>
                                </div>
                            @endif
                            @php $cant = $cant + 1 @endphp
                        @endforeach
    
                    </div>
                </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

</div> --}}

@endsection
