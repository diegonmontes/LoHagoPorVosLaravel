<!-- Mensajes -->
@if(Session::has('success'))
    <div class="alert alert-info col-md-8">
        {{Session::get('success')}}
    </div>
@endif
<!-- Anuncios -->
<div class="row">
    @if($busqueda)
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
                <form class="navbar-form" role="search" action="{{route('buscar')}}">
                    <div class="card-body">
                        <hr>
                        <div data-role="main" class="ui-content">
                            <div data-role="rangeslider">
                                <label for="rangoMonto">Monto:</label>
                                <input type="range" name="rangoMonto" id="rangoMonto" value="0" min="0" max="9999">
                            </div>
                        </div>
                        <hr>
                        Catgorias
                        <div class="form-check form-check">
                            @foreach($listaCategoria as $categoria)
                                <div class="form-check">
                                    <input class="form-check-input" style="left: -6px;top: -4px;" type="checkbox" value="{{$categoria->idCategoriaTrabajo}}" id="defaultCheck{{$categoria->idCategoria}}" name="categoria[]">
                                    <label class="form-check-label" for="defaultCheck{{$categoria->idCategoria}}">
                                        {{$categoria->nombreCategoriaTrabajo}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        Provincias
                        <div class="form-check form-check">
                            @foreach($provincias as $provincia)
                                <div class="form-check">
                                    <input class="form-check-input" style="left: -6px;top: -4px;" type="checkbox" value="{{$provincia->idProvincia}}" id="defaultCheck{{$provincia->idProvincia}}" name="provincia[]">
                                    <label class="form-check-label" for="defaultCheck{{$provincia->idProvincia}}">
                                        {{$provincia->nombreProvincia}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button class="btn btn-default" type="submit">Filtrar</button>

                </form>
            </div>
            </div>
        </div>   
    </div>
    @endif
        <div class="col-md-9">
            <div class="row">
            @foreach($listaTrabajos as $trabajo)
                <div class="card col-md-3 cardInicio">
                    
                    <div class="card-body">
                        
                        <h5 class="card-title">{{ucfirst($trabajo->titulo)}}</h5>
                    <hr>
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
</div>


                