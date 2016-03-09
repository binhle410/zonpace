<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', app_name())</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Ionicons -->
    {!! Html::style('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') !!}
    <!-- Theme style -->
    @yield('before-styles-end')
    {!! Html::style(elixir('css/backend.css')) !!}
    @yield('after-styles-end')
            <!-- iCheck -->
    {!! Html::style('js/vendor/iCheck/square/blue.css') !!}

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void(0)">@yield('box-title')</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">@yield('box-msg')</p>
        @include('includes.partials.messages')
        @yield('content')
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<!-- jQuery 2.1.4 -->
{!! Html::script('js/vendor/jquery/jQuery-2.1.4.min.js') !!}
<!-- Bootstrap 3.3.5 -->
{!! Html::script('js/vendor/bootstrap/bootstrap.min.js') !!}

@yield('before-scripts-end')
{!! Html::script(elixir('js/frontend.js')) !!}
@yield('after-scripts-end')
</body>
</html>
