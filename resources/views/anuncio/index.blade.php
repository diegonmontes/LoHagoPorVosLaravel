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

    

    <?php

	MercadoPago\SDK::setClientId("7175237490278996");
	MercadoPago\SDK::setClientSecret("bCl5t1V2TZAKKJKZ3Ss7qYebcqu6j33J");


 $preference = new MercadoPago\Preference();

 $produto1 = ['BOLA DE FUTEBOL', 1, '109,90'];
 $produto2 = ['CHUTEIRA NIKE', 1, '100,90'];
  
  # Building an item
  

  $item2 = new MercadoPago\Item();
  $item2->id = "00002";
  $item2->title = $produto2[0]; 
  $item2->quantity = $produto2[1];
  $item2->unit_price = str_replace(',', '.', $produto2[2]);



  
  $preference->items = array($item2);
  
  $preference->save(); # Save the preference and send the HTTP Request to create
  
  # Return the HTML code for button
  
  echo "<a href='$preference->sandbox_init_point'> Pagar </a>";

?>


<script type="text/javascriptMP">
    window.Mercadopago.setPublishableKey(ENV_PUBLIC_KEY);
    </script>
@endsection





