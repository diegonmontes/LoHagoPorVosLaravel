@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                            <h3>Lista de estado</h3>
                    </td>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                        <a href="{{ route('estado.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir un estado</a>
                    </td>
                </tr>
                    <tr>
                        <th>Estado</th>
                        <th>Descripcion</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($estados->count())
                @foreach($estados as $estado)
                    <tr>
                        <td>{{$estado->nombreEstado}}</td>
                        <td>{{$estado->descripcionEstado}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{action('EstadoController@edit', $estado->idEstado)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('EstadoController@destroy', $estado->idEstado)}}" method="post">
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
            {{ $estados->links() }}
</section>

@endsection
