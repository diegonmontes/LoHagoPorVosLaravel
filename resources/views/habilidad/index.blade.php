@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Habilidades</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('habilidad.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Habilidad</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Habilidad</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Imagen</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($habilidades->count())
                @foreach($habilidades as $habilidad)
                    <tr>
                        <td>{{$habilidad->idHabilidad}}</td>
                        <td>{{$habilidad->nombreHabilidad}}</td>
                        <td>{{$habilidad->descripcionHabilidad}}</td>
                        <td><img src="storage/trabajos/{{$habilidad->imagenHabilidad}}"width="100px;" height=></td>
                        
                        <td><a class="btn btn-primary btn-sm" href="{{action('HabilidadController@edit', $habilidad->idHabilidad)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('HabilidadController@destroy', $habilidad->idHabilidad)}}" method="post">
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
            {{ $habilidades->links() }}
</section>

@endsection
