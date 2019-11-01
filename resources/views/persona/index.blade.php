@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Lista Personas</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{route('persona.createpanel')}}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Persona</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Persona</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Telefono</th>
                        <th>Imagen</th>
                        <th>ID Usuario</th>
                        <th>Localidad</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($personas->count())
                @foreach($personas as $persona)
                    <tr>
                       
                        <td>{{$persona->idPersona}}</td>
                        <td>{{$persona->nombrePersona}}</td>
                        <td>{{$persona->apellidoPersona}}</td>
                        <td>{{$persona->dniPersona}}</td>
                        <td>{{$persona->telefonoPersona}}</td>
                        <td>{{$persona->imagenPersona}}</td>
                        <td>{{$persona->usuario->idUsuario.' - '.$persona->usuario->mailUsuario}}</td>
                        <td>{{$persona->localidad->idLocalidad.' - '.$persona->localidad->nombreLocalidad}}</td>
                        
                        <td><a class="btn btn-primary btn-sm" href="{{action('PersonaController@editpanel', $persona->idPersona)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('PersonaController@destroy', $persona->idPersona)}}" method="post">
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
            {{ $personas->links() }}
</section>

@endsection
