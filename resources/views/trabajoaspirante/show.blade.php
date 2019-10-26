@extends('layouts.layout')
@section('content')
<div class="container">
    @if( $success)
    <div class="card">
        <div class="card-body">
          <h5 class="card-title">Felicitaciones</h5>
          <p class="card-text">Ya se encuentra en la lista de los aspirantes para realizar el trabajo.</p>
          <p class="card-text">Revisa el mail o en las notificaciones para saber si sos el elegido.</p>

        <a href="{{route ('inicio')}}" class="btn btn-primary">¡Ir al inicio y buscar más trabajos!</a>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ups!</h5>
            <p class="card-text">Ocurrio un problema mientras realizabamos la operacion.</p>
            <p class="card-text">Intente nuevamente por favor.</p>
            <a href="{{route ('inicio')}}" class="btn btn-primary">¡Ir al inicio y volver a intentar!</a>
        </div>
    </div>
    @endif
</div>
@endsection