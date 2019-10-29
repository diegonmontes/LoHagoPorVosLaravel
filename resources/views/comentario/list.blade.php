@foreach($comentarios as $comentario)
	@include('comentario.item', ['comentario' => $comentario])
@endforeach