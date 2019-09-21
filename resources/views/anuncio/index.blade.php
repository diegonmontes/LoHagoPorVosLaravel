@extends('layouts.layout')
@section('content')
    <br>
    <section class="content" style="margin-left: 5%; margin-right: 5%;">
        <div class="row justify-content-center">

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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>TITULO DEL ANUNCIO</label><br>
                            <input type="text" name="titulo" id="titulo" class="form-control input-sm inputBordes" style="color: #1e1e27">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>DESCRIPCION</label><br>
                            <input type="text" name="descripcion" id="descripcion" class="form-control input-sm inputBordes" style="color: #1e1e27">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>MONTO</label><br>
                            <input type="number" name="monto" id="monto" class="form-control input-sm inputBordes" style="color: #1e1e27">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <label for="idCategoriaTrabajo">CATEGORIA</label>
                        <select class="form-control inputSelect" name="idCategoriaTrabajo" id="idCategoriaTrabajo" style="color: #1e1e27">
                            @foreach($listaCategoriaTrabajo as $unaCategoria)
                                <option value="{{$unaCategoria->idCategoriaTrabajo}}">
                                    {{$unaCategoria->nombreCategoriaTrabajo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <input type="submit"  value="¡Publicar!" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection





