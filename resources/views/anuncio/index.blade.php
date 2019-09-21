@extends('layouts.layout')
@section('content')
    <section class="content">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-info">
                {{Session::get('success')}}
            </div>
        @endif
        <form method="GET" action="{{ route('trabajo.store') }}"  role="form">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Titulo del anuncio:</label><br>
                        <input type="text" name="titulo" id="titulo" class="form-control input-sm">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Descripcion:</label><br>
                        <input type="text" name="descripcion" id="descripcion" class="form-control input-sm">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Monto:</label><br>
                        <input type="number" name="monto" id="monto" class="form-control input-sm">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <label for="idCategoriaTrabajo">Provincia:</label>
                    <select class="form-control" name="idCategoriaTrabajo" id="idCategoriaTrabajo">
                        @foreach($listaCategoriaTrabajo as $unaCategoria)
                            <option value="{{$unaCategoria->idCategoriaTrabajo}}">
                                {{$unaCategoria->nombreCategoriaTrabajo}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <input type="submit"  value="Guardar" class="btn btn-success btn-block">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <a href="{{ route('home') }}" class="btn btn-info btn-block" >Atrás</a>
                </div>
            </div>
        </form>
    </section>
@endsection





