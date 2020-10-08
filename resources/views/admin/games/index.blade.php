@extends('layout.index')

@section('title', 'Permainan')

@section('content')
<div class="bg-blue-tp">
    <div class="container-fluid">
        <div class="row dashboard">
            <div class="col-12">
                <div class="content-header">
                    <h1 class="content-title">Pilih permainan...</h1>
                </div>
                <div class="content-body">
                    @forelse($miniAssesmentGroup as $key => $v)
                        <div class="card-deck pl-4 pr-4 pb-4">
                            <div class="list-card-menu-item col-12" data-id="#">
                                <a href="{{ url('/admin/mini-assessment/'.$key) }}">
                                    <h3><i class="kejar-penilaian" ></i> {{$v}}</h3>
                                </a>
                            </div>
                        </div>
                    @empty
                    @endforelse
                    <div class="card-deck">
                        <a href="{{ url('/admin/obr/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/obr.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Operasi Bilangan Riil</h5>
                                <p class="card-text">Berhitung lebih cepat dan tepat agar belajar Matematika mudah dan lancar.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/katabaku/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/kata-baku.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Kata Baku</h5>
                                <p class="card-text">Menulis lebih profesional dengan Bahasa Indonesia yang baik dan benar.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/vocabulary/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/vocab.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Vocabulary</h5>
                                <p class="card-text">Lebih percaya diri menulis dan berbicara dalam Bahasa Inggris karena kosakata yang kaya.</p>
                            </div>
                        </a>
                    </div>
                    <div class="card-deck">
                        <a href="{{ url('/admin/toeicwords/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/toeic-words.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">TOEIC Words</h5>
                                <p class="card-text">Kuasai 4000 kosakata yang sering muncul pada TOEIC.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/menulisefektif/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/menulis-efektif.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Menulis Efektif</h5>
                                <p class="card-text">Menulis kata yang tepat agar menjadi kalimat yang efektif.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/soalcerita/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/soal-cerita.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Soal Cerita</h5>
                                <p class="card-text">Lebih cerdas menyelesaikan permasalahan di kehidupan sehari-hari dengan kemampuan matematika.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
