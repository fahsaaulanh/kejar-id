@extends('layout.main')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/onboarding.css') }}">
@endsection

@section('content')
<div class="row justify-content-center content">
    <div class="col-md-10 col-lg-6">
        <!-- Link Back -->
        <div class="d-flex justify-content-between top-link align-items-center">
            <div class="link-back d-flex align-items-center">
                <a href="{{ url('/students/games/' . str_replace(' ', '', $game) . '/stages/' . $stage['id'] . '/rounds/') }}" class="text-link"><i class="kejar kejar-arrow-left"></i> <span>Kembali</span></a>
            </div>
        </div>
        <!-- Breadcrumbs -->
        <nav class="breadcrumb bg-transparent p-0">
            <a class="breadcrumb-item" href="{{ url('/students/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/students/games/' . str_replace(' ', '', $game) . '/stages/') }}">{{ $game }}</a>
            <a class="breadcrumb-item" href="{{ url('/students/games/' . str_replace(' ', '', $game) . '/stages/' . $stage['id'] . '/rounds/') }}">{{ $stage['title'] }}</a>
            <span class="breadcrumb-item active">{{ $round['title'] }}</span>
        </nav>
        <!-- Title -->
        <h1 class="text-title">{{ $round['title'] }}</h1>
        <!-- Detail -->
        <div class="task-detail">
            <div class="task-detail">
                <h5 class="task-detail-amount">{{ $round['total_question'] }}</h5>
                <p class="task-detail-description">{{ $round['description'] }}</p>
            </div>

            <div class="detail-card rounded-0 border-0">
                <div class="detail-card-icon">
                    <i class="kejar kejar-open-book"></i>
                </div>
                <div class="detail-card-text">
                    {{ $round['direction'] }}
                </div>
            </div>
        </div>
        <!-- Start Button -->
        <div class="d-flex justify-content-end btn-start-group">
            <a href="{{ url('students/games/' . str_replace(' ', '', $game) . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/exams') }}" class="btn btn-primary btn-start d-flex align-items-center">
                Mulai <i class="kejar kejar-next"></i>
            </a>
        </div>
    </div>
</div>
@endsection