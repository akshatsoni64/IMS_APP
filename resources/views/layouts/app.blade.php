<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" href="cylinder.png">

    <!-- <title>
        {{ config('app.name', 'IMS') }} {{ (Auth::check()) ? '| '.Auth::user()->name : '' }}
    </title> -->

    <title>
        @php($route=Request::route()->getName())
        @php( $value=explode('.',$route) ) 
        {{ Str::title($value[0]) }}
        Page | IMS
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
            <div class="row border border-top-0 border-left-0 border-right-0">
                @if($value[0]!=="login" && $value[0]!=="register")
                    <div class="col-xl-2 text-center">
                        <p class="font-weight-bold pt-2">{{ date('l, d F Y') }}</p>
                        
                    </div>
                    <div class="col-xl-10">
                @else
                    <div class="col">
                @endif
                    <h1 align="center">
                        @if(Auth::check())
                            {{ Auth::user()->name.' | IMS' }}
                        @else
                            {{ 'Inventory Management System' }}
                        @endif
                    </h1>
                </div>
            </div>
        </nav>    

        <br><br><br>

        <div class="row mb-5">
            @yield('navbar')
            @if($value[0]!=="login" && $value[0]!=="register")
            <button 
                id="toggle-nav-div"
                type='button'
                title="Toggle Side Menu" 
                class="btn btn-dark fixed-bottom mb-5 ml-1"
            >
                <i class="font-weight-bold fa fa-angle-left"></i>
            </button>
            @endif
            @yield('content')
        </div>

        @if($value[0]!=="home" && $value[0]!=="login" && $value[0]!=="register" && $value[0]!=="report")
            <div class="mb-5 mr-4" style="position:fixed;bottom:0;right:0">
                @if($value[0] === "transaction")
                    <button 
                        type="button"
                        title="Print" 
                        class="shadow-lg btn btn-dark text-info rounded-circle"  
                        target="_blank"
                        data-toggle="modal" data-target="#report-field-modal"
                    >
                        <i class="fa fa-print"></i>
                    </button>
                @endif
                <button 
                    id="toggle-add-form"                    
                    title="Add {{ Str::title($value[0]) }}" 
                    class="shadow-lg btn btn-dark text-primary rounded-circle ml-1" 
                >
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        @endif

        <div class="text-right text-white fixed-bottom bg-dark">
            Designed by VINKS Sevices LLP &nbsp; 
        </div>
    </div>
</body>
</html>
