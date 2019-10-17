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
                            <h4>Completa todos los campos para publicar tu anuncio</h4>
                        </div>

                        <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>TITULO DEL ANUNCIO</label>
                                            <input type="text" name="titulo" id="titulo" class="form-control inputBordes" placeholder="El titulo de tu anuncio. Pensalo bien para llamar la atención.">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <label>IMAGEN</label>
                                        <div class="drag-drop-imagenTrabajo">
                                            <input type="file" id="files" accept="image/*"  onchange="showMyImage(this)" name="imagenTrabajo" />
                                            <output id="thumbnil" class="preview-imagenTrabajo"></output>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>DESCRIPCION</label><br>
                                            <textarea type="text" rows="6" name="descripcion" id="descripcion" class="form-control inputBordes" placeholder="Describe bien lo que quieres. Mientras más detalles mejor."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 ">
                                        <label for="idCategoriaTrabajo">CATEGORIA</label>
                                        <select class="form-control inputSelect" name="idCategoriaTrabajo" id="idCategoriaTrabajo">
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
                                            <label>MONTO</label>
                                            <input type="number" name="monto" id="monto" class="form-control input-sm inputBordes" placeholder="$" min="1" pattern="^[0-9]+">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>ESPERAR POSTULANTES HASTA:</label>
                                            <input type="text"  id="datepicker"  class="form-control inputBordes" placeholder="¿Hasta cuando se pueden postular?">
                                            <input type="text" id="datepickerAlt" name="tiempoExpiracion" class="datepicker-picker" >
                                        </div>
                                    </div>
                                </div>

                                
                                    
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <label for="idProvincia">PROVINCIA</label>
                                        <select class="form-control inputSelect" name="idProvincia" id="idProvincia" >
                                            @foreach ($provincias as $unaProvincia)
                                                <option value="{{$unaProvincia->idProvincia}}">
                                                    {{$unaProvincia->nombreProvincia}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <label for="idLocalidad" class="control-label">LOCALIDAD</label>
                                        <select name="idLocalidad" id="idLocalidad" class="form-control inputSelect">
                                            <option value="">Seleccione una opcion</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit"   class="btn btn-success btn-block btn-lg">¡Publicar!</button>
                                    </div>
                                </div>

                               @php

                                    MercadoPago\SDK::setClientId("7175237490278996");
                                    MercadoPago\SDK::setClientSecret("bCl5t1V2TZAKKJKZ3Ss7qYebcqu6j33J");


                                $preference = new MercadoPago\Preference();

                                $produto1 = ['BOLA DE FUTEBOL', 1, '109,90'];
                                $produto2 = ['CHUTEIRA NIKE', 1, '100,90'];
                                $item2 = new MercadoPago\Item();
                                $item2->id = "00002";
                                $item2->title = $produto2[0]; 
                                $item2->quantity = $produto2[1];
                                $item2->unit_price = str_replace(',', '.', $produto2[2]);



                                
                                $preference->items = array($item2);
                                
                                $preference->save(); # Save the preference and send the HTTP Request to create
                                
                                # Return the HTML code for button
                                
                                echo "<a href='$preference->sandbox_init_point'> Pagar </a>";

                            @endphp
                                <script type="text/javascriptMP">
                                    window.Mercadopago.setPublishableKey(ENV_PUBLIC_KEY);
                                </script>
                        </div>
                </div> 
            </form>
        </div>
    </section>
@endsection


