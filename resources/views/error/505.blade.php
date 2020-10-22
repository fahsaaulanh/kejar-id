@extends('layout.error')

@section('title', 'Error 505')

<!-- hides header -->
@section('header')
@endsection

@section('content')
    <div class="bg-grey">
        <div class="container">
            <div class="error-group error-505">
                <!-- Icon Alert -->
                <!-- <i class="kejar-belum-mengerjakan-2"></i> -->

                <!-- Error Description -->
                <!-- Pesan Lama -->
                    <!-- <h1>Sepertinya telah terjadi kesalahan</h1> -->
                    <!-- <h4>namun jangan khawatir, kamu tetap bisa semangat belajar dengan segarkan halaman atau kembali ke beranda.</h4> -->
                <!-- End Pesan Lama -->
                <h1>Hore! Jawabanmu sudah tersimpan dengan baik.</h1>
                <h4>Pastikan link GForm juga sudah diisi dengan sesuai.</h4>
                <p>
                    <span class="text-danger">*</span>
                    Apabila halaman ini muncul tidak saat mengumpulkan jawaban,<br> hubungi tim layanan.
                </p>

                <!-- Button Group -->
                <div class="d-flex flex-wrap">
                    <a href="{{ url()->current() }}" class="btn-refresh">Segarkan Halaman</a>
                    <a href="{{ url('/') }}" class="btn-home">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

@endsection
