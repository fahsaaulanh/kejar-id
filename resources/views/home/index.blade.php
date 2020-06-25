<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <!-- Styles -->
        <link href="{{ url('/assets/css/layout.css') }}" rel="stylesheet">
        <link href="{{ url('/assets/css/bootstrap.css') }}" rel="stylesheet">
    </head>
    <body class="default-body">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
                <a class="navbar-brand" href="#">Kejar Matrikulasi</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="form-inline my-2 my-lg-0">
                    <a href="{{ url('/logout') }}" class="btn btn-primary my-2 my-sm-0">Logout</a>
                </div>
            </nav>
        <div class="flex-center position-ref full-height">
            <h4>This is Home Page With Session.</h4>
            <div class="container">
                <div>
                    {{ json_encode(session('user')) }}
                </div>
            <div class="container">
        </div>
    </body>
</html>
