<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Siswa | Beranda</title>
        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
        <link href="{{ url('/assets/css/layout.css') }}" rel="stylesheet">
        <link href="{{ url('/assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ url('/assets/css/home/style.css') }}" rel="stylesheet">
    </head>
    
    <body>
        <nav class="navbar navbar-light bg-dark-custom align-items-center">
            <a class="navbar-brand align-items-center" href="#">
                <img src="{{ asset('assets/icons/kejarid.svg') }}" width="40" height="40" alt="" loading="lazy">
                {{ (session('user.username')) }}
            </a>
            <a href="{{ url('/logout') }}" class="btn-logout">Logout</a>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="content-header">
                        <h1 class="content-title">Pilih permainan...</h1>
                    </div>
                </div>
            </div>
                <div class="col-12">
                    <div class="content-body">
                        <div class="card-deck">
                            <a href="" class="card">
                                <img src="{{ asset('assets/images/home/obr.png') }}" class="card-img-top" alt="Gambar Permainan OBR">
                                <div class="card-body">
                                    <h5 class="card-title">Operasi Bilangan Riil</h5>
                                    <p class="card-text">Berhitung lebih cepat dan tepat agar belajar Matematika mudah dan lancar.</p>
                                </div>
                            </a>
                            <a href="" class="card">
                                <img src="{{ asset('assets/images/home/kata-baku.png') }}" class="card-img-top" alt="Gambar Permainan Kata Baku">
                                <div class="card-body">
                                    <h5 class="card-title">Kata Baku</h5>
                                    <p class="card-text">Menulis lebih profesional dengan Bahasa Indonesia yang baik dan benar.</p>
                                </div>
                            </a>
                            <a href="" class="card">
                                <img src="{{ asset('assets/images/home/vocab.png') }}" class="card-img-top" alt="Gambar Permainan Vocabulary">
                                <div class="card-body">
                                    <h5 class="card-title">Vocabulary</h5>
                                    <p class="card-text">Lebih percaya diri menulis dan berbicara dalam Bahasa Inggris karena kosakata yang kaya.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
