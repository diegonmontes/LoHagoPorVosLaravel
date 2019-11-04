@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Roles</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('rol.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Rol</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Rol</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($roles->count())
                @foreach($roles as $rol)
                    <tr>
                        <td>{{$rol->idRol}}</td>
                        <td>{{$rol->nombreRol}}</td>
                        <td>{{$rol->descripcionRol}}</td>
                        <td><a class="btn btn-primary btn-sm" href="{{action('RolController@edit', $rol->idRol)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('RolController@destroy', $rol->idRol)}}" method="post">
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
            {{ $roles->links() }}
</section>

@endsection
