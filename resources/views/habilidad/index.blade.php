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
                        @if($habilidad->imagenHabilidad!=null)
                            <td><img src="{{asset("images/imagenHabilidad/$habilidad->imagenHabilidad")}}" onClick=abrirImagen("{{$habilidad->imagenHabilidad}}") width="75px;" height="50px"></td>
                        @else
                            <td>{{$habilidad->imagenHabilidad}}</td>
                        @endif
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

            <!-- Modal -->
            <div id="modalConfirmacion" class="modal fade" role="dialog">
                <div class="modal-dialog">
                <!-- Contenido del modal -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Im&aacute;gen de la habilidad</h5>
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
    var linkImagen = '<img src="{{asset("images/imagenHabilidad")}}/' + valor + '" width="100%" height="150px"> </img>';
    $('.modal-body').html(linkImagen);
    $('#modalConfirmacion').modal("show");
    }
    
</script>
@endsection
