<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vmaxx</title>

    <!-- Styles -->
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Response.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/image-crop-styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/goalProgress.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body id="app-layout">
<header class="insidePageHeader">
    <div class="insidePageHeaderLeft">
        <a href="{{ url('/') }}"><img src="{{ asset('image/vmaxx_newlogo.png') }}" alt=""></a>
    </div>
    <div class="insidePageHeaderRight">
        @if (Auth::guest())
            <p></p>
            <span>
                    <a class="inside-page-header-register" id="header-register">Register</a>&numsp;&numsp;|&numsp; &numsp;<a class="header-login" id="header-login">Login</a>
                </span>
        @else
            <p>Welcome, {{ Auth::user()->name }} !</p>&nbsp;
            <span><a class="headerRegister">My Profile</a></span>&numsp;&numsp;|&numsp;&numsp;
            <span><a class="insidePageHeaderLogin" href="{{ url('/logout') }}">Logout</a></span>
        @endif
    </div>
</header>

@yield('content')

@include('auth.setting')

@section('pageEnd')
    @include('pageEnd')
@show
</body>
</html>

