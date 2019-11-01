<div class="p-4 border-left my-3" style="background-color: #fff; border-left: 1px #9a3db6 solid !important">
    <p class="font-weight-bold">{{ $comentario->User->nombreUsuario }} dijo:</p>
    <p>{{ $comentario->contenido }}</p>
    @if($trabajo->idPersona == Auth::user()->idUsuario)

    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#reply-{{$comentario->idComentario}}" aria-expanded="false" aria-controls="reply-{{$comentario->idComentario}}">
        Responder
    </button>
    <div class="collapse my-3" id="reply-{{$comentario->idComentario}}">
    <div class="card card-body">
            @include('comentario.form', ['comentario' => $comentario])
        </div>
    </div>
@endif

    @if ($comentario->Replies)
        @include('comentario.list', ['comentarios' => $comentario->Replies])
    @endif
</div>