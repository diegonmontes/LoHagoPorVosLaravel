@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Trabajos Asignados</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('trabajoasignado.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Trabajo Asignado</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Trabajo Asignado</th>
                        <th>Trabajo</th>
                        <th>Persona</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($trabajosAsignados->count())
                @foreach($trabajosAsignados as $trabajoAsignado)
                    <tr>
                        <td>{{$trabajoAsignado->idTrabajoAsignado}}</td>
                        <td>{{$trabajoAsignado->persona->idPersona." - ".$trabajoAsignado->persona->nombrePersona." ".$trabajoAsignado->persona->apellidoPersona}}</td>
                        <td>{{$trabajoAsignado->trabajo->idTrabajo." - ".$trabajoAsignado->trabajo->titulo}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{action('TrabajoasignadoController@edit', $trabajoAsignado->idTrabajoAsignado)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('TrabajoasignadoController@destroy', $trabajoAsignado->idTrabajoAsignado)}}" method="post">
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
            {{ $trabajosAsignados->links() }}
</section>

@endsection
