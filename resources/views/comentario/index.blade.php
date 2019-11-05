@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Comentarios</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('comentario.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Comentario</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Comentario</th>
                        <th>contenido</th>
                        <th>ID Trabajo</th>
                        <th>ID Persona</th>
                        <th>ID Padre</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($comentarios->count())
                @foreach($comentarios as $comentario)
                    <tr>
                       
                        <td>{{$comentario->idComentario}}</td>
                        <td>{{$comentario->contenido}}</td>
                        <td>{{$comentario->trabajo->idTrabajo.' - '.$comentario->trabajo->titulo}}</td>
                        <td>{{$comentario->persona->idPersona.' - '.$comentario->persona->nombrePersona.' '.$comentario->persona->apellidoPersona}}</td>
                        <td>{{$comentario->idComentarioPadre}}</td>


                        <td><a class="btn btn-primary btn-sm" href="{{action('ComentarioController@edit', $comentario->idComentario)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('ComentarioController@destroy', $comentario->idComentario)}}" method="post">
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
            {{ $comentarios->links() }}
</section>

@endsection
