@extends('layout.index')

@section('title', 'Permainan - ' . $round['title'])

@section('content')

<div class="container">
        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('students/games/' . strtolower(str_replace(' ', '', $game)) . '/stages/' . $stage['id'] . '/rounds') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('students/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('students/games/' . strtolower(str_replace(' ', '', $game)) . '/stages') }}">{{ $game }}</a>
            <a class="breadcrumb-item" href="{{ url('students/games/' . strtolower(str_replace(' ', '', $game)) . '/stages/' . $stage['id'] . '/rounds') }}">Babak {{ $stage['order'] }}</a>
            <span class="breadcrumb-item active">Ronde {{ $round['order'] }}</span>
        </nav>
        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{ $round['title'] }}</h2>
        </div>

        <!-- On Boarding -->
        <div class="onboarding-page">
            <div class="onboarding-page-description">
                <h4>{{ $round['total_question'] }} soal</h4>
                <p>{{ $round['description'] }}</p>
            </div>

            <div class="card">
                <div class="card-body">
                    <i class="kejar-open-book"></i>
                    <pre>{{ $round['material'] !== 'Buat Materi' ? $round['material'] : 'Tidak ada materi' }}</pre>
                </div>
            </div>
        </div>

        <!-- Button Next -->
        <div class="onboarding-button">
            <a href="{{ url('students/games/' . strtolower(str_replace(' ', '', $game)) . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/exams') }}" class="btn btn-next">
                Mulai <i class="kejar-next"></i>
            </a>
        </div>
        

    </div>

@endsection