@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="1" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Lista de categorias</h3>
                </td>
                <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                    <a href="{{ route('pagorecibido.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir una categoria</a>
                </td>
                </tr>
                    <tr>
                        <th>Id Pago Recibido</th>
                        <th>Trabajo</th>
                        <th>Id Pago</th>
                        <th>monto</th>
                        <th>metodo</th>
                        <th>tarjeta</th>
                        <th>fechaaprobado</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($pagoRecibidos->count())
                @foreach($pagoRecibidos as $pagoRecibido)
                    <tr>
                        <td>{{$pagoRecibido->idPagoRecibido}}</td>
                        <td>{{$pagoRecibido->trabajo->idTrabajo}}</td>
                        <td>{{$pagoRecibido->idPago}}</td>
                        <td>{{$pagoRecibido->monto}}</td>
                        <td>{{$pagoRecibido->metodo}}</td>
                        <td>{{$pagoRecibido->tarjeta}}</td>
                        <td>{{$pagoRecibido->fechaaprobado}}</td>
                        
                        
                        <td><a class="btn btn-primary btn-sm" href="{{action('PagorecibidoController@edit', $pagoRecibido->idPagoRecibido)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('PagorecibidoController@destroy', $pagoRecibido->idPagoRecibido)}}" method="post">
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
            {{ $pagoRecibidos->links() }}
</section>

@endsection
