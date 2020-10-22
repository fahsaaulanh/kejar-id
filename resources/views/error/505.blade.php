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
                <h1>Halo hai!</h1>
                <h4><strong>Mohon tunggu sebentar,</strong> <br><br>lakukan penyegaran (refresh) pada halaman ini untuk melanjutkan aktivitas.</h4>
                <p>
                    <span class="text-danger">*</span>
                    Jika kamu sedang menyimpan jawaban, tenang saja jawabanmu akan tetap tersimpan.<br><br>
                    Tetap pastikan backup jawaban pada link GForm sebelum menyelesaikan aktivitas ulangan.
                </p>

                <!-- Button Group -->
                <div class="d-flex flex-wrap mt-5">
                    <a href="{{ url()->current() }}" class="btn-refresh">Segarkan Halaman</a>
                    <a href="{{ url('/') }}" class="btn-home">Kembali ke Beranda</a>
                </div>
                <p class="mt-5">Semangat Kejar!</p>
            </div>
        </div>
    </div>

@endsection
