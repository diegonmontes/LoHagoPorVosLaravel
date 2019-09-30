@extends('panel')
@section('content')
  <section class="content">
          <div class="row">

          </div>
          <table class="table table-striped table-bordered table-hover">
              <thead>
              <tr><td colspan="3" style="background-color: #7D8D94">
                  <div class="float_left">
                      <h3>Lista Rol</h3>
                  </div>
                  <div class="float-right">
                      <a href="{{ route('rol.create') }}" class="btn btn-success" ><i class="fa fa-user"></i>Añadir Rol</a>
                  </div>
                  </td>
              </tr>
                  <tr>
                      <th>Descripcion</th>
                      <th class="col-2">Editar</th>
                      <th class="col-2">Eliminar</th>
                  </tr>
              </thead>
              <tbody>
              @if($roles->count())
                  @foreach($roles as $rol)
                      <tr>
                          <td>{{$rol->descripcionRol}}</td>
                          <td><a class="btn btn-primary btn-sm" href="{{action('RolController@edit', $rol->idRol)}}" ><i class="fas fa-edit"></i></a></td>
                          <td>
                              <form action="{{action('RolController@destroy', $rol->idRol)}}" method="post">
                                  {{ csrf_field() }}
                                  <input name="_method" type="hidden" value="DELETE">
                                  <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-user" aria-hidden="true"></i></button>
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
