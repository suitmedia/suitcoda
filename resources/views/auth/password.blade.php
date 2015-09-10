<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('assets/css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{ asset('assets/css/timeline.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    @section('custom-css')
        <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    @show

    <!-- Custom Fonts -->
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Input Your Email to Reset Password</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ action('Auth\PasswordController@postEmail') }}">
                        {!! csrf_field() !!}
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" name="email" type="email" autofocus>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">Send Password Reset Link</button>
                                @if (\Session::has('error'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('error')->first('email') }}</span>
                                @endif
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    @section('custom-js')
        <script src="{{ asset('assets/js/sb-admin-2.js') }}"></script>
    @show

</body>

</html>
