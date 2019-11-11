@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Valoraciones</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('valoracion.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Valoracion</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Valoraci&oacute;n</th>
                        <th>Valor</th>
                        <th>Persona</th>
                        <th>Trabajo</th>
                        <th>Comentario</th>
                        <th>Imagen </th>
                        
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($valoraciones->count())
                @foreach($valoraciones as $valoracion)
                    <tr>
                        <td>{{$valoracion->idValoracion}}</td>
                        <td>{{$valoracion->valor}}</td>
                        <td>{{$valoracion->persona->idPersona." - ".$valoracion->persona->nombrePersona." ".$valoracion->persona->apellidoPersona}}</td>
                        <td>{{$valoracion->trabajo->idTrabajo." - ".$valoracion->trabajo->titulo}}</td>
                        <td>{{$valoracion->comentarioValoracion}}</td>
                        @if($valoracion->imagenValoracion!=null)
                            <td><img src="{{asset("storage/valoracion/$valoracion->imagenValoracion")}}" onClick=abrirImagen("{{$valoracion->imagenValoracion}}") width="75px;" height="50px"></td>
                        @else
                            <td>{{$valoracion->imagenValoracion}}</td> 
                        @endif

                        <td><a class="btn btn-primary btn-sm" href="{{action('ValoracionController@edit', $valoracion->idValoracion)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('ValoracionController@destroy', $valoracion->idValoracion)}}" method="post">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="btn btn-danger btn-sm" type="submit"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8">No hay registro !!</td>
                </tr>
            @endif
            </tbody>
        </table>
            {{ $valoraciones->links() }}
            <!-- Modal -->
            <div id="modalConfirmacion" class="modal fade" role="dialog">
                <div class="modal-dialog">
                <!-- Contenido del modal -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Im&aacute;gen de la valoraci&oacute;n</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Texto del modal</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
</section>

@endsection

@section('jsAbrirModalImagen')
<script>
    function abrirImagen(valor){
    var linkImagen = '<img src="{{asset("storage/valoracion")}}/' + valor + '" width="100%" height="150px"> </img>';
    $('.modal-body').html(linkImagen);
    $('#modalConfirmacion').modal("show");
    }
    
</script>
@endsection
