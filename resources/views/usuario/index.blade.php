@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Lista Usuarios</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('usuario.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Usuario</a>
                    </td>
                </tr>
                    <tr>
                        <th>Id Usuario</th>
                        <th>Nombre Usuario</th>
                        <th>Mail Usuario</th>
                        <th>Auth Key</th>
                        <th>Clave Usuario</th>
                        <th>Rol</th>
                        <th>Mail Verificado</th>
                        <th>Remember token</th>
                        
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($usuarios->count())
                @foreach($usuarios as $usuario)
                    <tr>
                       
                        <td>{{$usuario->idUsuario}}</td>
                        <td>{{$usuario->nombreUsuario}}</td>
                        <td>{{$usuario->mailUsuario}}</td>
                        <td>{{$usuario->auth_key}}</td>
                        <td>{{$usuario->claveUsuario}}</td>
                        <td>{{$usuario->rol->idRol.' - '.$usuario->rol->nombreRol}}</td>
                        <td>{{$usuario->email_verified_at}}</td>
                        <td>{{$usuario->remember_token}}</td>
                        


                        <td><a class="btn btn-primary btn-sm" href="{{action('UserController@edit', $usuario->idUsuario)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('UserController@destroy', $usuario->idUsuario)}}" method="post">
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
            {{ $usuarios->links() }}
</section>

@endsection
