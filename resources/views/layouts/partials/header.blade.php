<br><br><br><br>
<br>
<!-- Anuncios -->
<div class="row" >
    @foreach($listaTrabajos as $trabajo)
        <div class="card" style="width: 18rem;margin: 1%">
            <div class="card-body">
                <h5 class="card-title">{{$trabajo->titulo}}</h5>
                <p class="card-text">{{$trabajo->descripcion}}</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-sm btn-primary">Ver anuncio</a>
                <label class="product_price float-right">${{$trabajo->monto}}</label>
            </div>
        </div>
    @endforeach
</div>

