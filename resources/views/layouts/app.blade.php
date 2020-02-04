<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dependency Checker</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="{{ asset('start-ui/img/favicon.ico') }}" rel="shortcut icon">
    <link rel="stylesheet"
          href="{{ asset('start-ui/css/lib/font-awesome/font-awesome.min.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet"
          href="{{ asset('start-ui/css/lib/bootstrap/bootstrap.min.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet"
          href="{{ asset('start-ui/css/separate/vendor/select2.min.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet"
          href="{{ asset('start-ui/css/separate/vendor/pnotify.min.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet"
          href="{{ asset('start-ui/css/separate/vendor/blockui.min.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet"
          href="{{ asset('start-ui/css/separate/pages/widgets.min.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet"
          href="{{ asset('start-ui/css/separate/vendor/bootstrap-daterangepicker.min.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet"
          href="{{ asset('start-ui/css/lib/bootstrap-table/bootstrap-table.min.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet" href="{{ asset('start-ui/css/main.css?v=') .config('services.script_cache')}}">
    <link rel="stylesheet" href="{{ asset('start-ui/css/custom.css?v=') .config('services.script_cache')}}">
    @yield('css')
</head>
<body>

<header class="site-header">
    <div class="container-fluid">
        <a href="/" class="site-logo">
            <img class="hidden-xs-down" src="{{ asset('start-ui/img/logo.png') }}" alt="">
            <img class="hidden-xs-up" src="{{ asset('start-ui/img/logo.png') }}" alt="">
        </a>
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    <div class="dropdown user-menu">
                        <a class="dropdown-item" href="{{ route('logout') }}"><span
                                class="font-icon glyphicon glyphicon-log-out"></span><b>Sign Out</b></a>
                    </div>
                    <button type="button" class="burger-right">
                        <i class="font-icon-menu-addl"></i>
                    </button>
                </div><!--.site-header-shown-->
                <div class="mobile-menu-right-overlay"></div>
                <div class="site-header-collapsed">
                    <div class="site-header-collapsed-in">
                        <div
                            class="dropdown dropdown-typical {{ Route::current()->getName() === 'repositories' ? 'open' : '' }}">
                            <a href="{{ route('repositories') }}" class="dropdown-toggle no-arr">
                                <span class="font-icon font-icon-home"></span> Repositories
                            </a>
                        </div>
                        <div
                            class="dropdown dropdown-typical {{ Route::current()->getName() === 'emails' ? 'open' : '' }}">
                            <a href="{{ route('emails') }}" class="dropdown-toggle no-arr">
                                <span class="font-icon font-icon-mail"></span> E-Mails
                            </a>
                        </div>
                    </div><!--.site-header-collapsed-in-->
                </div><!--.site-header-collapsed-->
            </div><!--site-header-content-in-->
        </div><!--.site-header-content-->
    </div><!--.container-fluid-->
</header><!--.site-header-->

<div class="page-content">
    <div class="container-fluid">
        <div id="modalsm" class="modal fade bd-example-modal-sm" tabindex="-1" role="document" aria-labelledby="modalsm"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content"></div>
            </div>
        </div>
        <div id="modalm" class="modal fade bd-example-modal-m" tabindex="-1" role="document" aria-labelledby="modalm"
             aria-hidden="true">
            <div class="modal-dialog modal-m">
                <div class="modal-content"></div>
            </div>
        </div>
        <div id="modal" class="modal fade" tabindex="-1" role="document" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>
        <div id="modallg" class="modal fade bd-example-modal-lg" tabindex="-1" role="document" aria-labelledby="modallg"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content"></div>
            </div>
        </div>
        @yield('content')
    </div><!--.container-fluid-->
</div><!--.page-content-->

<script src="{{ asset('start-ui/js/lib/jquery/jquery-3.2.1.min.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/bootstrap/bootstrap.min.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/plugins.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/select2/select2.full.min.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/blockUI/jquery.blockUI.js?v=').config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/pnotify/pnotify.js?v=').config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/moment/moment-with-locales.min.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/daterangepicker/daterangepicker.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/bootstrap-table/bootstrap-table.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/bootstrap-table/bootstrap-table-export.min.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/lib/bootstrap-table/tableExport.min.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/app.js?v=') .config('services.script_cache')}}"></script>
<script src="{{ asset('start-ui/js/custom.js?v=') .config('services.script_cache')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('js')
</body>
</html>
