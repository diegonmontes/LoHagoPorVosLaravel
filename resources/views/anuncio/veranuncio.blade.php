
@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="offset-md-2 col-md-6">
        <div class="card text-center">
            <div class="card-header">
                <h5 class="card-title">{{$trabajo->titulo}}</h5>
            </div>
            @if(!$trabajo->imagenTrabajo)
                <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image cap"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6" dy=".3em">Imagen del anuncio</text></svg>
            @endif
        <img src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}">
            <div class="card-body">
                <p class="card-text">{{$trabajo->descripcion}}</p>
            </div>

        </div>
    </div>
    <div class="col-md-4">
        <div class="card" style="width: 18rem;">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{$trabajo->titulo}}</li>
                <li class="list-group-item">${{$trabajo->monto}}</li>
                @php
                    $laravel=true;
                    
                    $link = json_decode($link);
                    # Return the HTML code for button
                    
                    echo "<a href=$link> Pagar </a>";

                @endphp


                <script type="text/javascriptMP">
                    window.Mercadopago.setPublishableKey(ENV_PUBLIC_KEY);
                </script>
                
                
                <li class="list-group-item"><a href="{{route ('postularme',$trabajo->idTrabajo)}}" class="btn btn-success btn-sm">Postularme</a></li>
            </ul>
        </div>
    </div>
</div>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="margin: auto;">
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

</div>

@endsection
