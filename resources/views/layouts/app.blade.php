<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.atwho.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('css/trix.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.2/trix.css" />
<script>
    window.App = {!! json_encode([
        'user' => Auth::user(),
        'signedIn' => Auth::check()
    ]) !!};
</script>
@yield('head')
</head>
<body>
    <div id="app">
            @include('layouts.nav')

            <div class=" mt-3">
            @yield('content')

            
     <flash></flash>
    </div>
        

           




    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/black/pace-theme-flash.css" />
</body>
</html>
