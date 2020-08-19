@extends('layout/index')

@section('title', 'Error 505')

<!-- hides header -->
@section('header')
@endsection

@section('content')
    <div class="bg-grey">
        <div class="container">
            <div class="error-group error-505">
                <!-- Icon Alert -->
                <i class="kejar-belum-mengerjakan-2"></i>

                <!-- Error Description -->
                <h1>Sepertinya telah terjadi kesalahan</h1>
                <h4>namun jangan khawatir, kamu tetap bisa semangat belajar dengan segarkan halaman atau kembali ke beranda.</h4>

                <!-- Button Group -->
                <div class="d-flex flex-wrap">
                    <a href="{{ url()->current() }}" class="btn-refresh">Segarkan Halaman</a>
                    <a href="{{ url('/') }}" class="btn-home">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
@endsection