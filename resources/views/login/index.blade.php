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
        <div class="flex-center position-ref full-height">
            <h4>This is Login Page.</h4>
            @if ($message)
                <p class="text-danger">{{ $message }}</p>
            @endif
            <form method="POST" id="loginForm" action="{{ url('/login/doLogin') }}">
                @csrf
                <div class="form-group mt-1">
                    <Label for="username">Username</Label>
                    <input class="form-control id="username" type="text" name="username" />
                </div>
                <div class="form-group mt-1">
                    <Label for="password">Password</Label>
                    <input class="form-control  id="password" type="password" name="password" />
                </div>
                <button class="btn btn-primary mt-1" id="submit" type="submit" class="mt-1">Login</button>
            </form>
        </div>
    </body>
</html>
