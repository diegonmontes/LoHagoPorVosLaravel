@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Trabajos aspirantes</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('trabajoaspirante.createpanel') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Asignar un trabajo</a>
                      </td>
                </tr>
                    <tr>
                        <th>Id Trabajo Aspirante</th>
                        <th>Trabajo</th>
                        <th>Persona</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($trabajosAspirantes->count())
                @foreach($trabajosAspirantes as $trabajoAspirante)
                    <tr>
                        <td>{{$trabajoAspirante->idTrabajoAspirante}}</td>
                        <td>{{$trabajoAspirante->persona->idPersona." - ".$trabajoAspirante->persona->nombrePersona." ".$trabajoAspirante->persona->apellidoPersona}}</td>
                        <td>{{$trabajoAspirante->trabajo->idTrabajo." - ".$trabajoAspirante->trabajo->titulo}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{action('TrabajoaspiranteController@editpanel', $trabajoAspirante->idTrabajoAspirante)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('TrabajoaspiranteController@destroy', $trabajoAspirante->idTrabajoAspirante)}}" method="post">
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
            {{ $trabajosAspirantes->links() }}
</section>

@endsection
