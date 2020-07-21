<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <!-- Styles -->
        <link rel="icon" href="{{ url('assets/icon/fackejar.png') }}" type="image/gif">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        @yield('css')
    </head>
    <body>
        <nav class="navbar navbar-light bg-dark-custom align-items-center">
        <a class="navbar-brand align-items-center" href="#">
            <img src="{{ asset('assets/icons/kejarid.svg') }}" width="40" height="40" alt="" loading="lazy">
            {{ session('user.username') }}
        </a>
        <a href="{{ url('/logout') }}" class="btn-logout">Logout</a>
        </nav>

        <div class="container-fluid">
            @yield('content')
        </div>
    </body>
    <script src="{{ mix('/js/app.js') }}"></script>
    @stack('script')
</html>
