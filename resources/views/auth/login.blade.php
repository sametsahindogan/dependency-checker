<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sign In</title>

    <link href="{{ asset('start-ui/img/favicon.144x144.png') }}" rel="apple-touch-icon" type="image/png"
          sizes="144x144">
    <link href="{{ asset('start-ui/img/favicon.114x114.png') }}" rel="apple-touch-icon" type="image/png"
          sizes="114x114">
    <link href="{{ asset('start-ui/img/favicon.72x72.png') }}" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="{{ asset('start-ui/img/favicon.57x57.png') }}" rel="apple-touch-icon" type="image/png">
    <link href="{{ asset('start-ui/img/favicon.png') }}" rel="icon" type="image/png">
    <link href="{{ asset('start-ui/img/favicon.ico') }}" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('start-ui/css/separate/pages/login.min.css') }}">
    <link rel="stylesheet" href="{{ asset('start-ui/css/lib/font-awesome/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('start-ui/css/lib/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('start-ui/css/main.css') }}">
</head>
<body>

<div class="page-center">
    <div class="page-center-in">
        <div class="container-fluid">
            <form class="sign-box" method="POST" action="{{ route('login.post') }}">
                {{ csrf_field() }}
                <div class="row justify-content-center" style="margin: 25px 0 40px 0;">
                    <img src="{{ asset('start-ui/img/logo.png') }}"  width="200" alt="">
                </div>
                <div class="form-group {{ $errors->has('email') ? 'error' : '' }}">
                    <input type="email" class="form-control" name="email" placeholder="E-Mail"
                           value="{{ old('email') }}" autofocus autocomplete="off"/>
                    @if ($errors->has('email'))
                        <div class="error-list" data-error-list="">
                            <ul>
                                <li>{{ $errors->first('email') }}</li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'error' : '' }}">
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off"/>
                    @if ($errors->has('password'))
                        <div class="error-list" data-error-list="">
                            <ul>
                                <li>{{ $errors->first('password') }}</li>
                            </ul>
                        </div>
                    @endif
                </div>
                @if(session()->has('login_error'))
                    <div class="alert alert-danger">
                        {{ session()->get('login_error') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-rounded">Login</button>
            </form>
        </div>
    </div>
</div><!--.page-center-->


<script src="{{ asset('start-ui/js/lib/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('start-ui/js/lib/popper/popper.min.js') }}"></script>
<script src="{{ asset('start-ui/js/lib/tether/tether.min.js') }}"></script>
<script src="{{ asset('start-ui/js/lib/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('start-ui/js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('start-ui/js/lib/match-height/jquery.matchHeight.min.js') }}"></script>
<script>
    $(function () {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function () {
            setTimeout(function () {
                $('.page-center').matchHeight({remove: true});
                $('.page-center').matchHeight({
                    target: $('html')
                });
            }, 100);
        });
    });
</script>
<script src="{{ asset('start-ui/js/app.js') }}"></script>
</body>
</html>
