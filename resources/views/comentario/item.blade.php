<div class="p-4 border-left my-3">
    <p class="font-weight-bold">User {{ $comentario->Usuario->nombreUsuario }}:</p>
    <p>{{ $comentario->contenido }}</p>
    
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#reply-{{$comentario->idComentario}}" aria-expanded="false" aria-controls="reply-{{$comentario->idComentario}}">
        Reply
    </button>
 
    <div class="collapse my-3" id="reply-{{$comentario->idComentario}}">
    <div class="card card-body">
            @include('comentario.form', ['comentario' => $comentario])
        </div>
    </div>

    @if ($comentario->Replies)
        @include('comentario.list', ['comentarios' => $comentario->Replies])
    @endif
</div>