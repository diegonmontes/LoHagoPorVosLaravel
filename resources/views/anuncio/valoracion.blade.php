
@extends('layouts.layout')
@section('css')

<style >
.rating {
    display: inline-block;
    position: relative;
    height: 50px;
    line-height: 50px;
    font-size: 50px;
  }
  
  .rating label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    cursor: pointer;
  }
  
  .rating label:last-child {
    position: static;
  }
  
  .rating label:nth-child(1) {
    z-index: 5;
  }
  
  .rating label:nth-child(2) {
    z-index: 4;
  }
  
  .rating label:nth-child(3) {
    z-index: 3;
  }
  
  .rating label:nth-child(4) {
    z-index: 2;
  }
  
  .rating label:nth-child(5) {
    z-index: 1;
  }
  
  .rating label input {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
  }
  
  .rating label .icon {
    float: left;
    color: transparent;
  }
  
  .rating label:last-child .icon {
    color: #000;
  }
  
  .rating:not(:hover) label input:checked ~ .icon,
  .rating:hover label:hover input ~ .icon {
    color: #09f;
  }
  
  .rating label input:focus:not(:checked) ~ .icon:last-child {
    color: #000;
    text-shadow: 0 0 5px #09f;
  }
</style>
@endsection


@section('content')
<section class="container h-100">
<div class="row h-100 justify-content-center ">
    <h1>aca va un formulario para que complete y starse la persona</h1>

    <form method="POST" id="formTerminado" name="formTerminado" action="{{route('trabajo.valorarpersona')}}"  role="form">
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group">
                <label>Describe y starsa el trabajo realizado</label>
                <textarea type="text" name="descripcionTrabajo" id="descripcionTrabajo" class="form-control input-sm"></textarea>
            </div>
        </div>
    <input type="hidden" name="idTrabajo" id="idTrabajo" value="{{$trabajo->idTrabajo}}">
    <div class="rating">
        <label>
            <input type="radio" name="stars" value="1" />
            <span class="fa fa-star icon"></span>
          </label>
          <label>
            <input type="radio" name="stars" value="2" />
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
          </label>
          <label>
            <input type="radio" name="stars" value="3" />
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>   
          </label>
          <label>
            <input type="radio" name="stars" value="4" />
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
          </label>
          <label>
            <input type="radio" name="stars" value="5" />
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
            <span class="fa fa-star icon"></span>
          </label>
    </div>
        <br>
        <div class="row">
                <input type="submit"  value="Enviar y finalizar el trabajo" class="btn btn-success btn-block">
        </div>
    </form>
</div>
</section>
@endsection
