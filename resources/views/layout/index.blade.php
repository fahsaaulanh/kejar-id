<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @section('header')
        <nav class="navbar navbar-light bg-dark-custom align-items-center">
            <a class="navbar-brand align-items-center" href="#">
                <img src="{{ asset('assets/icons/kejarid.svg') }}" width="40" height="40" alt="" loading="lazy">
                {{ session('user.username') }}
            </a>
            <a href="{{ url('/logout') }}" class="btn-logout">Logout</a>
        </nav>
    @show

    @yield('content')

</body>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</html>