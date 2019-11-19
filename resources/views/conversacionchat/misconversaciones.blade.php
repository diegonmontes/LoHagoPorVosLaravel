@extends('layouts.layout')
@section('content')
    @foreach ($listaConversaciones as $conversacion)
        @php print_R($conversacion)@endphp
    @endforeach 
@endsection