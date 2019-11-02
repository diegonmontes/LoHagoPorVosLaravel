
@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Lista Trabajos</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{route('trabajo.createpanel')}}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Trabajo</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Trabajo</th>
                        <th>Estado</th>
                        <th>Categoria</th>
                        <th>Persona</th>
                        <th>Localidad</th>
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th>Monto</th>
                        <th>Imagen</th>
                        <th>Tiempo Expiracion</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($trabajos->count())
                @foreach($trabajos as $trabajo)
                    <tr>
                       
                        <td>{{$trabajo->idTrabajo}}</td>
                        <td>{{$trabajo->estado->idEstado .' - '.$trabajo->estado->nombreEstado}}</td>
                        <td>{{$trabajo->categoriaTrabajo->idCategoriaTrabajo.' - '.$trabajo->categoriaTrabajo->nombreCategoriaTrabajo}}</td>
                        <td>{{$trabajo->persona->idPersona.' - '.$trabajo->persona->nombrePersona.' '.$trabajo->persona->apellidoPersona}}</td>
                        <td>{{$trabajo->localidad->idLocalidad.' - '.$trabajo->localidad->nombreLocalidad}}</td>
                        <td>{{$trabajo->titulo}}</td>
                        <td>{{$trabajo->descripcion}}</td>
                        <td>{{$trabajo->monto}}</td>
                        <td>{{$trabajo->imagenTrabajo}}</td>
                        <td>{{$trabajo->tiempoExpiracion}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{action('TrabajoController@editpanel', $trabajo->idTrabajo)}}" ><i class="fas fa-edit"></i></a></td>
                                                
                        <td>
                            <form action="{{action('TrabajoController@destroy', $trabajo->idTrabajo)}}" method="post">
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
            {{ $trabajos->links() }}
</section>

@endsection
