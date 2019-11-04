@extends('admin')
@section('content')
<section class="content">
        <table class="table table-light table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <td colspan="2" style="background-color: #343a40; border-color: #343a40; color:#FFF">
                        <h3>Mensajes</h3>
                      </td>
                      <td colspan="2" style="background-color: #343a40; border-color: #343a40">
                            <a href="{{ route('mensajechat.create') }}" class="btn btn-success" ><i class="fas fa-plus"></i>Añadir Mensaje</a>
                    </td>
                </tr>
                    <tr>
                        <th>Id Mensaje</th>
                        <th>Id Conversacion</th>
                        <th>Persona</th>
                        <th>Mensaje</th>
                        <th colspan="1">Editar</th>
                        <th colspan="1">Eliminar</th>
                    </tr>
            </thead>
            <tbody>
            @if($mensajeschats->count())
                @foreach($mensajeschats as $mensaje)
                    <tr>
                       
                        <td>{{$mensaje->idMensajeChat}}</td>
                        <td>{{$mensaje->ConversacionChat->idConversacionChat}}</td>
                        <td>{{$mensaje->persona->idPersona.' - '.$mensaje->persona->nombrePersona.' '.$mensaje->persona->apellidoPersona}}</td>
                        <td>{{$mensaje->mensaje}}</td>


                        <td><a class="btn btn-primary btn-sm" href="{{action('MensajeChatController@edit', $mensaje->idMensajeChat)}}" ><i class="fas fa-edit"></i></a></td>
                        <td>
                            <form action="{{action('MensajeChatController@destroy', $mensaje->idMensajeChat)}}" method="post">
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
            {{ $mensajeschats->links() }}
</section>

@endsection
