<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ url('assets/icon/fackejar.png') }}" type="image/gif">
    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

</head>
<body>
    @section('header')
        <nav class="navbar">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/icons/kejarid.svg') }}" alt="" loading="lazy">
                {{ session('user.username') }}
            </a>
            <a class="btn-logout" href="{{ url('/logout') }}">Logout</a>
        </nav>
    @show

    @yield('content')

</body>
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>

    @stack('script')
</html>
