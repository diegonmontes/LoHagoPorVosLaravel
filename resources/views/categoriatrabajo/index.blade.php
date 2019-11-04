@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="1" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Categor&iacute;as</h3>
                </td>
                <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                    <a href="{{ route('categoriatrabajo.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir una categoria</a>
                </td>
                </tr>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Imagen</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($categoriasTrabajo->count())
                @foreach($categoriasTrabajo as $categoriaTrabajo)
                    <tr>
                        <td>{{$categoriaTrabajo->nombreCategoriaTrabajo}}</td>
                        <td>{{$categoriaTrabajo->descripcionCategoriaTrabajo}}</td>
                        <td>{{$categoriaTrabajo->imagenCategoriaTrabajo}}</td>
                        
                        <td><a class="btn btn-primary btn-sm" href="{{action('CategoriaTrabajoController@edit', $categoriaTrabajo->idCategoriaTrabajo)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('CategoriaTrabajoController@destroy', $categoriaTrabajo->idCategoriaTrabajo)}}" method="post">
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
            {{ $categoriasTrabajo->links() }}
</section>

@endsection
