<!DOCTYPE html>
<html>
<head>
    <title>Actualizacion de mail</title>
</head>

<body>
<h2>Hola {{$nombreUsuario}}</h2>
<br>
Para actualizar el mail debés validar tu correo electronico haciendo click en el siguiente boton
<br>
<a href="{{ route('validarmail',[$auth_key,$id]) }}"><button>Validar mi email</button></a>
<br>
En caso que no funcione el boton copia y pega el siguiente enlace en tu navegador web
<br>
<a href="{{ route('validarmail',[$auth_key,$id]) }}">{{ route('validarmail',[$auth_key,$id]) }}</a>
<br>
</body>

</html>