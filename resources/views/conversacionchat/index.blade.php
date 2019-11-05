@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Conversaciones</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('conversacionchat.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Conversacion</a>
                    </td>
                </tr>
                <tr>
                    <th>ID Conversaci&oacute;n</th>
                    <th>Trabajo </th>
                    <th>Persona 1</th>
                    <th>Persona 2</th>
                    <th colspan="1">Editar</th>
                    <th colspan="1">Eliminar</th>
                </tr>
                    
            </thead>
            <tbody>
            @if($conversaciones->count())
                @foreach($conversaciones as $conversacion)
                    <tr>
                        <td>{{$conversacion->idConversacionChat}}</td>
                        <td>{{$conversacion->trabajo->idTrabajo." - ".$conversacion->trabajo->titulo}}</td>
                        <td>{{$conversacion->persona1->idPersona. " - ". $conversacion->persona1->nombrePersona. " ".$conversacion->persona1->apellidoPersona}}</td>
                        <td>{{$conversacion->persona2->idPersona. " - ". $conversacion->persona2->nombrePersona. " ".$conversacion->persona2->apellidoPersona}}</td>

                        <td><a class="btn btn-primary btn-sm" href="{{action('ConversacionChatController@edit', $conversacion->idConversacionChat)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('ConversacionChatController@destroy', $conversacion->idConversacionChat)}}" method="post">
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
            {{ $conversaciones->links() }}
</section>

@endsection
