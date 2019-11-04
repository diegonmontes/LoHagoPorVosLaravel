@extends('admin')
@section('content')
  <section class="content">
    <table class="table table-light table-bordered table-hover">
      <thead class="thead-dark">
          <tr>
              <td colspan="3" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                  <h3>Localidad</h3>
              </td>
              <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                    <a href="{{ route('localidad.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Localidad</a>
              </td>
          </tr>
          <tr>
              <th>ID Localidad</th>
              <th>Localidad</th>
              <th>Codigo Postal</th>
              <th>Provincia</th>
              <th colspan="1">Editar</th>
              <th colspan="1">Eliminar</th>
          </tr>
      </thead>
      <tbody>
              @if($localidades->count())  
              @foreach($localidades as $localidad)
              <tr>
                <td>{{$localidad->idLocalidad}}</td>
                <td>{{$localidad->nombreLocalidad}}</td>
                <td>{{$localidad->codigoPostal}}</td>
                <td>{{$localidad->provincia->nombreProvincia}}</td>

                <td><a class="btn btn-primary btn-xs" href="{{action('LocalidadController@edit', $localidad->idLocalidad)}}" ><i class="fas fa-edit"></i></a></td>
                <td>
                  <form action="{{action('LocalidadController@destroy', $localidad->idLocalidad)}}" method="post">
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
      {{ $localidades->links() }}
  </section>
@endsection