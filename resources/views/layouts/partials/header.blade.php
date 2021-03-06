{{-- <!-- Mensajes -->
@if(Session::has('success'))
    <div class="alert alert-info col-md-8">
        {{Session::get('success')}}
    </div>
@endif --}}


<!-- carousel -->
@if(!$busqueda)

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
          <img class="d-block w-100 imgCarousel" data-src="holder.js/800x400?auto=yes&amp;bg=777&amp;fg=555&amp;text=First slide" alt="First slide [800x400]" src="{{asset('images/lohagoporvosBannerUno.png')}}" data-holder-rendered="true">            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
                <img class="d-block w-100 imgCarousel" data-src="holder.js/800x400?auto=yes&amp;bg=777&amp;fg=555&amp;text=First slide" alt="First slide [800x400]" src="{{asset('images/lohagoporvosBannerDos.png')}}" data-holder-rendered="true">            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
                <img class="d-block w-100 imgCarousel" data-src="holder.js/800x400?auto=yes&amp;bg=777&amp;fg=555&amp;text=First slide" alt="First slide [800x400]" src="{{asset('images/lohagoporvosBannerTres.png')}}" data-holder-rendered="true">            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
        </div>
        <a class="carousel-control-prev botonPreviousCarousel" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next botonNextCarousel" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
@endif
<!-- Anuncios -->
    @if($busqueda)
    <div class="row">
        <!-- Panel de busqueda -->
        <div class="col-md-2">
            <div id="accordion">
                <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                    <button class="btn btn-toolbar" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-filter"></i> Filtros
                    </button>
                    </h5>
                </div>
            
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <form id="formFiltrar" name="formFiltrar" role="form" action="{{route('buscar')}}" method="GET">

                        <div class="card-body">
                            <hr>
                            <div class="form-group">
                                <label for="rangoMontoInferior">Monto minimo:</label>
                                <input type="number" name="rangoMontoInferior" id="rangoMontoInferior" class="form-control input-sm inputBordes" placeholder="$" min="0" pattern="^[0-9]+" style="-moz-appearance: textfield;">
                            </div>
                            <div class="form-group">
                                <label for="rangoMontoSuperior">Monto maximo:</label>
                                <input type="number" name="rangoMontoSuperior" id="rangoMontoSuperior" class="form-control input-sm inputBordes" placeholder="$" min="0" pattern="^[0-9]+" style="-moz-appearance: textfield;">
                            </div>
                            <hr>
                            Categorias
                            <div class="form-check form-check">
                                @foreach($listaCategoria as $categoria)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{$categoria->idCategoriaTrabajo}}" id="defaultCheck{{$categoria->idCategoriaTrabajo}}" name="categoria[]">
                                        <label class="form-check-label" for="defaultCheck{{$categoria->idCategoriaTrabajo}}">
                                            {{$categoria->nombreCategoriaTrabajo}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            <hr>
                            Provincias
                            <ul class="nav flex-column" role="tablist">
                                @foreach($provincias as $provincia)
                                <li class="nav-item">
                                    <a class="nav-link" href="#@php echo str_replace(" ","",(strtolower($provincia->nombreProvincia))) @endphp" role="tab" data-toggle="tab" aria-selected="true">{{$provincia->nombreProvincia}}</a>  
                                </li>
                                @endforeach
                            </ul>
                            <hr>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                    

                                @foreach($provincias as $provincia)
                                <div role="tabpanel" class="tab-pane" id="@php echo str_replace(" ","",(strtolower($provincia->nombreProvincia))) @endphp">
                                        Localidades
                                    <div class="form-check form-check">
                                    @foreach($provincia->Localidad as $localidad)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$localidad->idLocalidad}}" id="defaultCheck{{$localidad->idLocalidad}}" name="localidad[]">
                                            <label class="form-check-label" for="defaultCheck{{$localidad->idLocalidad}}">
                                                {{$localidad->nombreLocalidad}}
                                            </label>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">Filtrar</button>

                    </form>
                </div>
                </div>
            </div>   
        </div>

        
    @endif

    <div class="@if(!$busqueda) container @else col-md-9 @endif">
                <div class="row">
            @foreach($listaTrabajos as $trabajo)
                <div class="card col-md-3 cardInicio margenCardInicio">
                        <div class="card-header">
                                <h5 class="card-title">{{ucfirst($trabajo->titulo)}}</h5>
                            </div>
                    <div class="card-body">
                        
                    @if($trabajo->imagenTrabajo == null || $trabajo->imagenTrabajo == '')
                        @php 
                        
                        $categoria = $categoriaTrabajo::find($trabajo->idCategoriaTrabajo);
                        $imagenCategoria = $categoria->imagenCategoriaTrabajo;

                        @endphp
                        
                        <img class="imagenAnuncio" src="{{ asset("images/imagenCategoria/$imagenCategoria" )}}" alt="{{$imagenCategoria}}">

                    @else
                        <img class="imagenAnuncio" src="{{ asset("storage/trabajos/$trabajo->imagenTrabajo" )}}" alt="{{$trabajo->imagenTrabajo}}">

                    @endif
                
                @php $descripcion = substr($trabajo->descripcion, 0, 100)  @endphp
                        <p class="card-text">{{$descripcion}} @if(strlen($trabajo->descripcion) > strlen($descripcion)){{'...' }} @endif</p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="veranuncio/{{$trabajo->idTrabajo}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                            </div>
                            <div class="col-md-6">
                                <label class="row precioAnuncio float-right"><div class="signoPeso"><i class="fas fa-dollar-sign"></i></div>{{$trabajo->monto}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
</div>
@if($busqueda)  </div>  @endif