@extends('layouts.layout')
@section('content')
    <section class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
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
            <div class="col-xs-12 col-sm-12 col-md-8">
                <form method="post" action="{{ route('trabajo.store') }}" enctype="multipart/form-data" role="form">
                    {{ csrf_field() }}
                    <div class="card">
                            <div class="card-header">
                                <h4>Completa todos los campos para publicar tu anuncio</h4>
                            </div>

                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>TITULO DEL ANUNCIO*</label>
                                                <input type="text" name="titulo" id="titulo" class="form-control inputBordes" placeholder="El titulo de tu anuncio. Pensalo bien para llamar la atención." required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <label>INGRESE UNA IMAGEN(opcional)</label>
                                            <div class="drag-drop-imagenTrabajo imagenTrabajo">
                                                <input type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenTrabajo" />
                                                <output id="thumbnil" class="preview-imagenTrabajo">
                                                        <img class="preview-imagenTrabajo" src="{{asset('images/subirImagen.png')}}" style="width: 30%; margin: auto;">

                                                </output>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label>DESCRIPCION*</label><br>
                                                <textarea type="text" rows="6" name="descripcion" id="descripcion" class="form-control inputBordes" placeholder="Describe bien lo que quieres. Mientras más detalles mejor." required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 ">
                                            <label for="idCategoriaTrabajo">CATEGORIA*</label>
                                            <select class="form-control inputSelect" name="idCategoriaTrabajo" id="idCategoriaTrabajo" required>
                                                <option value="" disabled selected>Seleccione una categoria</option>
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
                                                <label>MONTO*</label>
                                                <input type="number" name="monto" id="monto" class="form-control input-sm inputBordes" placeholder="$" min="1" pattern="^[0-9]+" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>ESPERAR POSTULANTES HASTA*</label>
                                                <input type="text"  id="datepicker"  class="form-control inputBordes" placeholder="¿Hasta cuando se pueden postular?" required>
                                                <input type="text" id="datepickerAlt" name="tiempoExpiracion" class="datepicker-picker" >
                                            </div>
                                        </div>
                                    </div>

                                    
                                        
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <label for="idProvincia">PROVINCIA*</label>
                                            <select class="form-control inputSelect" name="idProvincia" id="idProvincia" >
                                                @foreach ($provincias as $unaProvincia)
                                                    <option value="{{$unaProvincia->idProvincia}}">
                                                        {{$unaProvincia->nombreProvincia}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <label for="idLocalidad" class="control-label">LOCALIDAD*</label>
                                            <select name="idLocalidad" id="idLocalidad" class="form-control inputSelect">
                                                <option value="">Seleccione una opcion</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <h6>Lo campos que tienen (*) son obligatorios</h6>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit"   class="btn btn-success btn-block btn-lg">¡Publicar!</button>
                                        </div>
                                    </div>
                            </div>
                    </div> 
                </form>
            </div>
        </div>

    </section>
@endsection


