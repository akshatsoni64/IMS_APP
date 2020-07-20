<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" href="cylinder.png">

    <title>
        {{ config('app.name', 'IMS') }} {{ (Auth::check()) ? '| '.Auth::user()->name : '' }}
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .form-control:focus{
            box-shadow:none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">

        <nav class="fixed-top pt-2 bg-light">
            <div class="border border-top-0 border-left-0 border-right-0">
                <h1 align="center">
                    @if(Auth::check())
                        {{ Auth::user()->name.' | IMS' }}
                    @else
                        {{ 'Inventory Management System' }}
                    @endif
                </h1>
            </div>
        </nav>    

        <br><br><br>

        <div class="row mb-5">
            @yield('navbar')
            @yield('content')
        </div>

        <div class="text-right text-white fixed-bottom bg-dark">
            Designed by VINKS Sevices LLP &nbsp; 
        </div>
    </div>
</body>
</html>
