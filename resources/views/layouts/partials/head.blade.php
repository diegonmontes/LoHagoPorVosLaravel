<meta charset="utf-8">
<title>Lo hago por vos</title>

<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Icono -->
<link rel="shortcut icon" href="images/lohagoporvos.ico">
<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">

<!-- Styles -->
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link rel="stylesheet" type="text/css"  href="{{ asset('css/fontawesome-free/css/all.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('css/estiloPropio.css') }}">
{{-- <script src="{{asset('js/app.js')}}" defer></script> --}}

<!-- Scripts -->
<script defer>
  window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
      'pusherKey' => config('broadcasting.connections.pusher.key'),
      'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
  ]) !!};
</script>



