<!-- Mensajes -->
@if(Session::has('success'))
    <div class="alert alert-info col-md-8">
        {{Session::get('success')}}
    </div>
@endif
<!-- Anuncios -->
<div class="row app" style="margin: auto">
    @foreach($listaTrabajos as $trabajo)
        <div class="card margenCardInicio">
            <div class="card-body">
                <h5 class="card-title">{{$trabajo->titulo}}</h5>
                <p class="card-text">{{$trabajo->descripcion}}</p>
            </div>
            <div class="card-footer">
                <a href="veranuncio/{{$trabajo->idTrabajo}}" class="btn btn-sm btn-primary">Ver anuncio</a>
                <label class="product_price float-right">${{$trabajo->monto}}</label>
            </div>
        </div>
    @endforeach
</div>



                