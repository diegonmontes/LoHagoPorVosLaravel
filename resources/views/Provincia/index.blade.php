@extends('admin')
@section('content')
  <section class="content">
      <table class="table table-striped table-bordered table-hover">
          <thead>
              <tr>
                <td colspan="4" style="background-color: #7D8D94">
                  <div class="float_left">
                      <h3>Lista Rol</h3>
                  </div>
                  <div class="float-right">
                    <a href="{{ route('provincia.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i></i>Añadir Provincia</a>
                  </div>
                </td>
              </tr>
              <tr>
                  <th>Provincia</th>
                  <th>Codigo Iso 31662</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </tr>
          </thead>
             <tbody>
              @if($provincias->count())  
              @foreach($provincias as $provincia)
              <tr>
                <td>{{$provincia->nombreProvincia}}</td>
                <td>{{$provincia->codigoIso31662}}</td>

                <td><a class="btn btn-primary btn-xs" href="{{action('ProvinciaController@edit', $provincia->idProvincia)}}" ><i class="fas fa-edit"></i></a></td>
                <td>
                  <form action="{{action('ProvinciaController@destroy', $provincia->idProvincia)}}" method="post">
                  {{ csrf_field() }}
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger btn-xs" type="submit"><i class="far fa-trash-alt"></i></button>
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
      {{ $provincias->links() }}
</section>
 
@endsection