<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="icon" href="{{ url('assets/logo/favicon.png') }}" type="image/gif">
        <!-- Styles -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        <!-- Import CSS -->
        @yield('css')
    </head>
    <body>
        @yield('content')
    </body>
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>

    @stack('script')
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117909356-4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.js" integrity="sha512-giNJUOlLO0dY67uM6egCyoEHV/pBZ048SNOoPH4d6zJNnPcrRkZcxpo3gsNnsy+MI8hjKk/NRAOTFVE/u0HtCQ==" crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-117909356-4');
    </script>

</html>
