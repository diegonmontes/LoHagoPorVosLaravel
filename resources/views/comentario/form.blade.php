<form id="formComentario" class="formComentario" action="{{route('comentario.store')}}" method="POST">
	{{ csrf_field() }}
	
	@if (isset($comentario->idComentario))
		<input type="hidden" id="idComentarioPadre" name="idComentarioPadre" value="{{$comentario->idComentario}}">
	@endif
	<input type="hidden" id="idTrabajo" name="idTrabajo" value="{{$trabajo->idTrabajo}}">

	<input type="hidden" id="idUsuario" name="idUsuario" value="{{\auth()->id()}}">
 	
 	<div class="form-group">
		<label for="content">Preguntar, responder u opinar...</label>
		<textarea class="form-control contenido" name="contenido" id="contenido"></textarea>
	</div>
  	<button id="subirComentario" type="submit" class="btn btn-primary subirComentario">Enviar</button>
</form>