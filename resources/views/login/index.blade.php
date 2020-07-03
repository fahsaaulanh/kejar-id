<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Selamat Datang</title>
        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
        <link href="{{ url('/assets/css/layout.css') }}" rel="stylesheet">
        <link href="{{ url('/assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ url('/assets/css/login/style.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="login-container">
            <div class="login-header">
                <h5>Kejar Matrikulasi</h5>
            </div>
            <div class="bg-mobile"></div>
            <div class="login-body">
                <form method="POST" id="loginForm" action="{{ url('/login/doLogin') }}">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" autocomplete="off" placeholder="Ketik username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" autocomplete="off" placeholder="Ketik password">
                    </div>
                    <button type="submit" class="btn btn-block btn-login">Masuk</button>
                </form>
            </div>
        </div>
    </body>
</html>
