@extends('admin')
@section('content')
  <section class="content">
      <table class="table table-light table-bordered table-hover">
          <thead class="thead-dark">
              <tr>
                  <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                    <h3>Provincias</h3>
                  </td>
                  <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                    <a href="{{ route('provincia.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i></i>Añadir Provincia</a>
                  </td>
              </tr>
              <tr>
                  <th>ID Provincia </th>
                  <th>Provincia</th>
                  <th>Codigo Iso 31662</th>
                  <th colspan="1">Editar</th>
                  <th colspan="1">Eliminar</th>
              </tr>
          </thead>
             <tbody>
              @if($provincias->count())  
              @foreach($provincias as $provincia)
              <tr>
                <td>{{$provincia->idProvincia}}</td>
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