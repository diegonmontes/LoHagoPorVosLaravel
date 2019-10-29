<form action="{{route('comentario.store')}}" method="POST">
	{{ csrf_field() }}
	
	@if (isset($comentario->idComentario))
		<input type="hidden" name="idComentarioPadre" value="{{$comentario->idComentario}}">
	@endif
	<input type="hidden" name="idTrabajo" value="{{$trabajo->idTrabajo}}">

	<input type="hidden" name="idUsuario" value="{{\auth()->id()}}">
 	
 	<div class="form-group">
		<label for="content">Content:</label>
		<textarea class="form-control" name="contenido" id="contenido"></textarea>
	</div>
  	<button type="submit" class="btn btn-primary">Send</button>
</form>