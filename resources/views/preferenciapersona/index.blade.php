@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Lista Preferencia persona</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('preferenciapersona.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Preferencia a persona</a>
                    </td>
                </tr>
                    <tr>
                        <th>Id Preferencia Persona </th>
                        <th>Persona</th>
                        <th>Categoria Trabajo</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($preferenciasPersona->count())
                @foreach($preferenciasPersona as $preferenciaPersona)
                    <tr>
                        <td>{{$preferenciaPersona->idPreferenciaPersona}}
                        <td>{{$preferenciaPersona->persona->idPersona." - ".$preferenciaPersona->persona->nombrePersona." ".$preferenciaPersona->persona->apellidoPersona}}</td>
                        <td>{{$preferenciaPersona->categoriaTrabajo->idCategoriaTrabajo." - ".$preferenciaPersona->categoriaTrabajo->nombreCategoriaTrabajo}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{action('PreferenciaPersonaController@edit', $preferenciaPersona->idPreferenciaPersona)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('PreferenciaPersonaController@destroy', $preferenciaPersona->idPreferenciaPersona)}}" method="post">
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
            {{ $preferenciasPersona->links() }}
</section>

@endsection
