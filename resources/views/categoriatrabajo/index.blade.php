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
                        <th>ID Categor&iacute;a</th>
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
                        <td>{{$categoriaTrabajo->idCategoriaTrabajo}}</td>
                        <td>{{$categoriaTrabajo->nombreCategoriaTrabajo}}</td>
                        <td>{{$categoriaTrabajo->descripcionCategoriaTrabajo}}</td>
                        @if($categoriaTrabajo->imagenCategoriaTrabajo!=null)
                            <td><img src="/LoHagoPorVosLaravel/public/storage/trabajos/{{$categoriaTrabajo->imagenCategoriaTrabajo}}" onClick=abrirImagen("{{$categoriaTrabajo->imagenCategoriaTrabajo}}") width="75px;" height="50px"></td>
                        @else
                            <td>{{$categoriaTrabajo->imagenCategoriaTrabajo}}</td> 
                        @endif
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
             <!-- Modal -->
             <div id="modalConfirmacion" class="modal fade" role="dialog">
                <div class="modal-dialog">
                <!-- Contenido del modal -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Im&aacute;gen de la categor&iacute;a</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Texto del modal</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
</section>

@endsection

@section('jsAbrirModalImagen')
<script>
    function abrirImagen(valor){
    var linkImagen = '<img src="/LoHagoPorVosLaravel/public/storage/trabajos/' + valor + '" width="100%" height="150px"> </img>';
    $('.modal-body').html(linkImagen);
    $('#modalConfirmacion').modal("show");
    }
    
</script>
@endsection