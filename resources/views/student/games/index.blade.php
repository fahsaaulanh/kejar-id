@extends('layout.main')

@section('title', 'Student Games')

@section('css')
<link href="{{ url('/assets/css/home/style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="content-header">
            <h1 class="content-title">Pilih permainan...</h1>
        </div>
    </div>
    <div class="col-12">
        <div class="content-body">
            <div class="card-deck">
                <a href="{{ url('students/games/obr/stages') }}" class="card">
                    <img src="{{ asset('assets/images/home/obr.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Operasi Bilangan Riil</h5>
                        <p class="card-text">Berhitung lebih cepat dan tepat agar belajar Matematika mudah dan lancar.</p>
                    </div>
                </a>
                <a href="{{ url('students/games/katabaku/stages') }}" class="card">
                    <img src="{{ asset('assets/images/home/kata-baku.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Kata Baku</h5>
                        <p class="card-text">Menulis lebih profesional dengan Bahasa Indonesia yang baik dan benar.</p>
                    </div>
                </a>
                <a href="{{ url('students/games/vocabulary/stages') }}" class="card">
                    <img src="{{ asset('assets/images/home/vocab.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Vocabulary</h5>
                        <p class="card-text">Lebih percaya diri menulis dan berbicara dalam Bahasa Inggris karena kosakata yang kaya.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
