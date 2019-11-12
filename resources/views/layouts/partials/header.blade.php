<!-- Mensajes -->
@if(Session::has('success'))
    <div class="alert alert-info col-md-8">
        {{Session::get('success')}}
    </div>
@endif
<!-- Anuncios -->
<div class="row app" style="margin: auto">
    @foreach($listaTrabajos as $trabajo)
        <div class="card margenCardInicio cardInicio">
            
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



                