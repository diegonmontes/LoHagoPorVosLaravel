@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Habilidades de las personas</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('habilidadpersona.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Habilidad a persona</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Habilidad Persona</th>
                        <th>Persona</th>
                        <th>Habilidad</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($habilidadesPersona->count())
                @foreach($habilidadesPersona as $habilidadPersona)
                    <tr>
                        <td>{{$habilidadPersona->idHabilidadPersona}}</td>
                        <td>{{$habilidadPersona->persona->idPersona." - ".$habilidadPersona->persona->nombrePersona." ".$habilidadPersona->apellidoPersona}}</td>
                        <td>{{$habilidadPersona->habilidad->idHabilidad." - ".$habilidadPersona->habilidad->nombreHabilidad}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{action('HabilidadPersonaController@edit', $habilidadPersona->idHabilidadPersona)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('HabilidadPersonaController@destroy', $habilidadPersona->idHabilidadPersona)}}" method="post">
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
            {{ $habilidadesPersona->links() }}
</section>

@endsection
