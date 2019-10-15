@extends('layouts.layout')
@section('content')
    <section class="container">

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
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2">
            <form method="post" action="{{ route('trabajo.store') }}" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
                <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="drag-drop">
                                        <input type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenTrabajo" />
                                        <img id="thumbnil" class="preview"   src="http://localhost/LoHagoPorVosLaravel/public/images/fotoperfil.png"/>
                                        <span class="desc">Pulse aquí para añadir una imagen</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>TITULO DEL ANUNCIO</label><br>
                                            <input type="text" name="titulo" id="titulo" class="form-control inputBordes">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>DESCRIPCION</label><br>
                                            <textarea type="text" rows="6" name="descripcion" id="descripcion" class="form-control inputBordes"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <label for="idCategoriaTrabajo">CATEGORIA</label>
                                        <select class="form-control inputSelect" name="idCategoriaTrabajo" id="idCategoriaTrabajo">
                                            @foreach($listaCategoriaTrabajo as $unaCategoria)
                                            <option value="{{$unaCategoria->idCategoriaTrabajo}}">
                                                {{$unaCategoria->nombreCategoriaTrabajo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>MONTO</label>
                                            <input type="number" name="monto" id="monto" class="form-control input-sm inputBordes">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>ESPERAR POSTULANTES HASTA:</label>
                                            <input type="text"  id="datepicker"  class="form-control inputBordes">
                                            <input type="text" id="datepickerAlt" name="tiempoExpiracion" class="datepicker-picker">
                                        </div>
                                    </div>
                                </div>

                                
                                    
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <label for="idProvincia">PROVINCIA</label>
                                        <select class="form-control inputSelect" name="idProvincia" id="idProvincia" style="color: #1e1e27">
                                            @foreach ($provincias as $unaProvincia)
                                                <option value="{{$unaProvincia->idProvincia}}">
                                                    {{$unaProvincia->nombreProvincia}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <label for="idLocalidad" class="control-label">LOCALIDAD</label>
                                        <select name="idLocalidad" id="idLocalidad" class="form-control inputSelect" style="color: #1e1e27">
                                            <option value="">Seleccione una opcion</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit"   class="btn btn-success btn-block">¡Publicar!</button>
                                    </div>
                                </div>
                        </div>
                </div> 
            </form>
        </div>
    </section>
@endsection


