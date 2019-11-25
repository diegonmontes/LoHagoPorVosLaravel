<meta charset="utf-8">
<title>Lo hago por vos</title>

<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Icono -->
<link rel="shortcut icon" href="{{asset('images/lohagoporvos.ico')}}">

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">

<!-- Script -->
<script src="{{asset('js/app.js')}}" defer></script>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>

<!-- Pusher -->
<script defer>
  window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
      'pusherKey' => config('broadcasting.connections.pusher.key'),
      'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
  ]) !!};
</script>

<!-- Styles -->
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link rel="stylesheet" type="text/css"  href="{{ asset('css/fontawesome-free/css/all.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/estiloPropio.css') }}">



