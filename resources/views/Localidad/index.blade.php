@extends('layouts.layout')
@section('content')
<div class="row">
  <section class="content">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="pull-left"><h3>Lista Localidad</h3></div>
          <div class="pull-right">
            <div class="btn-group">
              <a href="{{ route('localidad.create') }}" class="btn btn-info" >Añadir Localidad</a>
            </div>
          </div>
          <div class="table-container">
            <table id="mytable" class="table table-bordred table-striped">
             <thead>
               <th>Localidad</th>
               <th>Provincia</th>
               <th>Editar</th>
               <th>Eliminar</th>
             </thead>
             <tbody>
              @if($localidades->count())  
              @foreach($localidades as $localidad)
              <tr>
                <td>{{$localidad->nombreLocalidad}}</td>
                <td>{{$localidad->provincia->nombreProvincia}}</td>

                <td><a class="btn btn-primary btn-xs" href="{{action('LocalidadController@edit', $localidad->idLocalidad)}}" ><span class="glyphicon glyphicon-pencil"></span></a></td>
                <td>
                  <form action="{{action('LocalidadController@destroy', $localidad->idLocalidad)}}" method="post">
                  {{ csrf_field() }}
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger btn-xs" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
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
        </div>
      </div>
      {{ $localidades->links() }}
    </div>
  </div>
</section>
 
@endsection