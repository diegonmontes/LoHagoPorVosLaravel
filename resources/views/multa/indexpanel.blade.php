@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Multas</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('multa.createpanel') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Multa</a>
                    </td>
                </tr>
                    <tr>
                        <th>ID Multa</th>
                        <th>ID Persona</th>
                        <th>ID Trabajo</th>
                        <th>Valor</th>
                        <th>Motivo</th>
                        
                        
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($multas->count())
                @foreach($multas as $multa)
                    <tr>
                        <td>{{$multa->idMulta}}</td>
                        <td>{{$multa->persona->idPersona." - ".$multa->persona->nombrePersona." ".$multa->persona->apellidoPersona}}</td>
                        <td>{{$multa->trabajo->idTrabajo." - ".$multa->trabajo->titulo}}</td>
                        <td>{{$multa->valor}}</td>
                        <td>{{$multa->motivo}}</td>
                        
                        <td><a class="btn btn-primary btn-sm" href="{{action('MultaController@edit', $multa->idMulta)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('MultaController@destroy', $multa->idMulta)}}" method="post">
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
            {{ $multas->links() }}
            
</section>

@endsection
