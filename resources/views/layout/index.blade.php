<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="icon" href="{{ url('assets/logo/favicon.png') }}" type="image/gif">
        <!-- Styles -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        @section('header')
        <nav class="navbar">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/logo/kejarid.svg') }}" alt="" loading="lazy">
                {{ session('user.username') }}
            </a>
            <a class="btn-logout" href="{{ url('/logout') }}">Logout</a>
        </nav>
        @show

        @yield('content')

        @include('shared._update_password')
    </body>
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>

    @stack('script')
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117909356-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-117909356-4');
    </script>
    @if($errors->has('password_baru'))
    <script>
        $('#updatePassword').modal('show');
    </script>
    @endif
    <script>

        $(document).ready(function() {
            $(".input-group-password").on('click', 'button', function(event) {
                event.preventDefault();
                var input = $(this).parents('.input-group-password').find('input');
                if ($(input).attr('type') == 'password'){
                    $(input).attr('type', 'text');
                    $(this).text('tutup');
                } else{
                    $(this).text('lihat');
                    $(input).attr('type', 'password');
                }
            });
        });
    </script>
</html>
