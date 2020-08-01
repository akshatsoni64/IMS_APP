<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" href="{{ asset('img/cylinder.png') }}">

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
                    <h2 align="center">
                        @if(Auth::check())
                            @if($value[0] == "home")
                                {{ Auth::user()->name.' | '.Str::title($value[0]) }}
                            @elseif($value[0] == "stock")
                                {{ Auth::user()->name.' | Opening '.Str::title($value[0]) }}
                            @else
                                {{ Auth::user()->name.' | '.Str::title($value[0]).'s' }}
                            @endif
                        @else
                            {{ 'Inventory Management System' }}
                        @endif
                    </h2>
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
                class="btn btn-dark fixed-bottom mb-5 ml-3 pl-3 pr-3"
            >
                <i class="font-weight-bold fa fa-angle-left"></i>
            </button>
            @endif
            @yield('content')
        </div>

        <div class="mb-5 mr-4" style="position:fixed;bottom:0;right:0">
            @if($value[0] == "home")
                <a target="_blank" href="{{ route('dashboard_summary')}}">
                    <button 
                        type="button"
                        title="Print Report" 
                        class="shadow-lg btn btn-dark text-info rounded-circle"  
                    >
                        <i class="fa fa-print"></i>
                    </button>
                </a>
            @elseif($value[0] == "customer" || $value[0] == "product")
                <button 
                    id="toggle-add-form"                    
                    title="Add {{ Str::title($value[0]) }}" 
                    class="shadow-lg btn btn-dark text-primary rounded-circle ml-1" 
                    {{ $value[1] == "edit" ? 'disabled' : '' }}
                >
                    <i class="fa fa-plus"></i>
                </button>
            @elseif($value[0] == "transaction")
                <button 
                    id="toggle-add-form"                    
                    title="Add {{ Str::title($value[0]) }}" 
                    class="shadow-lg btn btn-dark text-primary rounded-circle ml-1" 
                    {{ $value[1] == "edit" ? 'disabled' : '' }}
                >
                    <i class="fa fa-plus"></i>
                </button>
                <button 
                    type="button"
                    title="Print" 
                    class="shadow-lg btn btn-dark text-info rounded-circle"  
                    target="_blank"
                    data-toggle="modal" data-target="#report-field-modal"
                >
                    <i class="fa fa-print"></i>
                </button>
            @elseif($value[0] == "stock")
                <button 
                    id="toggle-add-form"                    
                    title="Add {{ Str::title($value[0]) }}" 
                    class="shadow-lg btn btn-dark text-primary rounded-circle ml-1" 
                    {{ $value[1] == "edit" ? 'disabled' : '' }}
                >
                    <i class="fa fa-plus"></i>
                </button>
            @elseif($value[0] == "report")
                <button 
                    type="button"
                    onclick="
                        $('#report-form').attr('action',`{{ route('getpdf') }}`);
                        $('#report-form').attr('target','_blank');
                        $('#report-form').submit();
                    "
                    title="Print Report" 
                    class="shadow-lg btn btn-dark text-info rounded-circle"  
                >
                    <i class="fa fa-print"></i>
                </button>
                <button 
                    type="button"
                    id="toggle-reportform"
                    title="Toggle Report Form" 
                    class="shadow-lg btn btn-dark text-white rounded-circle"  
                >
                    <i class="fa fa-wpforms"></i>
                </button>
            @endif
        </div>

        <div class="text-right text-white fixed-bottom bg-dark">
            Designed by VINKS Sevices LLP &nbsp; 
        </div>
    </div>
</body>
</html>
