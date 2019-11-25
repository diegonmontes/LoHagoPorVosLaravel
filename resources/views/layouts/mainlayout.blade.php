<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
   @include('layouts.partials.head')
 </head>
 <body>

    @include('layouts.partials.nav')
    @include('layouts.partials.header')
    <div id="app">
    @yield('content')
    </div>
    @include('layouts.partials.footer')
    @include('layouts.partials.footer-scripts')

</body>
</html>
