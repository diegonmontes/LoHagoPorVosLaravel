@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Historial estados de los trabajos</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('estadotrabajo.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir un estado a un trabajo</a>
                    </td>
                </tr>
                    <tr>
                        <th>Id Estado Trabajo</th>
                        <th>Trabajo</th>
                        <th>Estado</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($Estadotrabajos->count())
                @foreach($Estadotrabajos as $estadoTrabajo)
                    <tr>
                        <td>{{$estadoTrabajo->idEstadoTrabajo}}</td>
                        <td>{{$estadoTrabajo->trabajo->idTrabajo." - ".$estadoTrabajo->trabajo->titulo}}</td>
                        <td>{{$estadoTrabajo->estado->idEstado." - ".$estadoTrabajo->estado->nombreEstado}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{action('EstadotrabajoController@edit', $estadoTrabajo->idEstadoTrabajo)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                        <form action="{{action('EstadotrabajoController@destroy', $estadoTrabajo->idEstadoTrabajo)}}" method="post">
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
            {{ $Estadotrabajos->links() }}
</section>

@endsection
