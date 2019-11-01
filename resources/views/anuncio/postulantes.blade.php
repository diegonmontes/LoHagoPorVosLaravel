
@section('css')
<style type="text/css"> 
.profile 
{
    min-height: 355px;
    display: inline-block;
    }
figcaption.ratings
{
    margin-top:20px;
    }
figcaption.ratings a
{
    color:#f1c40f;
    font-size:11px;
    }
figcaption.ratings a:hover
{
    color:#f39c12;
    text-decoration:none;
    }
.divider 
{
    border-top:1px solid rgba(0,0,0,0.1);
    }
.emphasis 
{
    border-top: 4px solid transparent;
    }
.emphasis:hover 
{
    border-top: 4px solid #1abc9c;
    }
.emphasis h2
{
    margin-bottom:0;
    }
span.tags 
{
    background: #1abc9c;
    border-radius: 2px;
    color: #f5f5f5;
    font-weight: bold;
    padding: 2px 4px;
    }
.dropdown-menu 
{
    background-color: #34495e;    
    box-shadow: none;
    -webkit-box-shadow: none;
    width: 250px;
    margin-left: -125px;
    left: 50%;
    }
.dropdown-menu .divider 
{
    background:none;    
    }
.dropdown-menu>li>a
{
    color:#f5f5f5;
    }
.dropup .dropdown-menu 
{
    margin-bottom:10px;
    }
.dropup .dropdown-menu:before 
{
    content: "";
    border-top: 10px solid #34495e;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    bottom: -10px;
    left: 50%;
    margin-left: -10px;
    z-index: 10;
    }

</style>
@endsection


@if(count($listaPostulantes)>0)
<br>
<div class="card">
    <ul class="list-group list-group-flush">
    @foreach($listaPostulantes as $postulante)
    @php $persona = $postulante->Persona[0] @endphp
    <div class="well profile">
    <div class="col-sm-12">
        <div class="col-xs-12 col-sm-10">
        <h2>{{$persona->apellidoPersona}} {{$persona->nombrePersona}}</h2>
            <p><strong>Usuario: </strong> {{$persona->User->nombreUsuario}} </p>
            <p><strong>Localidad: </strong> {{$persona->Localidad->nombreLocalidad}} </p>
            <p><strong>Skills: </strong>
                @php
                    print_r($persona->HabilidadPersona);
                @endphp
                @foreach($persona->HabilidadPersona as $habilidad)
                    <span class="tags">{{$habilidad->nombreHabilidad}}</span> 
                @endforeach
            </p>
        </div>             
        <div class="col-xs-12 col-sm-4 text-center">
            <figure>
                <img src="http://www.agbrands.com.ar/wp-content/uploads/2017/01/perfil.jpg" alt="" class="img-circle img-responsive">
                <figcaption class="ratings">
                    <p>Ratings
                    <a href="#">
                        <span class="fa fa-star"></span>
                    </a>
                    <a href="#">
                        <span class="fa fa-star"></span>
                    </a>
                    <a href="#">
                        <span class="fa fa-star"></span>
                    </a>
                    <a href="#">
                        <span class="fa fa-star"></span>
                    </a>
                    <a href="#">
                         <span class="fa fa-star-o"></span>
                    </a> 
                    </p>
                </figcaption>
            </figure>
        </div>
    </div>
    </div>


      <form action="{{route('trabajoasignado.store')}}" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="idTrabajo" value="{{$trabajo->idTrabajo}}">
      
        <input type="hidden" name="idPersona" value="{{$persona->idPersona}}">
      
          <button type="submit" class="btn btn-sm align-right btn-success" style="position: absolute;right: 0%;margin-right: 5px;top: 18%;">Elegir</button>
      </form>

    @endforeach
    </ul>
  </div>
    
@endif