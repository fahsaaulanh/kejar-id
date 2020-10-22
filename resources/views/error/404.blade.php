@extends('layout.error')

@section('title', 'Error 404')

<!-- hides header -->
@section('header')
@endsection

@section('content')
    <div class="bg-grey">
        <div class="container">
            <div class="error-group error-404">
                <!-- Icon Alert -->
                <img src="{{ asset('assets/images/error/question-mark.png') }}" alt="">

                <!-- Error Description -->
                <h1>Sudah dicari ke mana-mana</h1>
                <h5>namun kami tetap tidak menemukan halaman yang kamu cari. Tetap semangat belajar! Mainkan lagi, yuk, dengan kembali ke beranda.</h5>

                <!-- Button Group -->
                <div class="d-flex flex-wrap">
                    <a href="{{ url('/') }}" class="btn-home">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
@endsection
