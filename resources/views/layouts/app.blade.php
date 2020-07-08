<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Selamat Datang</title>
        <!-- Styles -->
        <link rel="shortcut icon" href="https://kejar.id/assets/img/logo/fackejar.png" type="image/x-icon">
        <link href="{{ url('/assets/css/layout.css') }}" rel="stylesheet">
        <link href="{{ url('/assets/css/bootstrap.css') }}" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
  
        <!-- Custom -->
        @yield('styles')
    </head>
    <body class="default-body">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
            <a class="navbar-brand __navbar_brand" href="#">
                <img src="https://kejar.id/assets/img/logo/fackejar.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                {{ (session('user.username')) }}
            </a>
            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="form-inline my-2 my-lg-0">
                <a href="{{ url('/logout') }}" class="btn text-white my-2 my-sm-0">Logout</a>
            </div>
        </nav>
        @yield('content')
    </body>
    <script src="{{ url('assets/js/jquery.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.js') }}"></script>
    @yield('scripts')
    </html>
