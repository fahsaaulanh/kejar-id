@extends('layout.main')

@section('title', 'Student Stages')

@section('css')
<link rel="stylesheet" href="{{ url('/assets/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ url('/assets/css/student_game.css') }}">
@endsection

@section('content')

        <!-- Content -->
        <div class="container-fluid">
            <div class="row justify-content-center content">
                <div class="col-md-10 col-lg-6">

                    <!-- Link back -->
                    <div class="link-back">
                        <a href="{{ url('/students/games') }}" class="text-link d-flex align-items-center">
                            <i class="kejar kejar-arrow-left"></i> <span class="ml-2">Kembali</span>
                        </a>
                    </div>

                    <!-- Breadcrumb -->
                    <nav class="breadcrumb bg-transparent p-0">
                        <a class="breadcrumb-item" href="{{ url('/students/games') }}">Beranda</a>
                        <span class="breadcrumb-item active">{{ $game['uri'] }}</span>
                    </nav>

                    <!-- Title -->
                    <h1 class="text-title">{{ $game['title'] }}</h1>

                    <!-- Stages Group -->
                    <div class="stages-group">
                        <!-- Stage Item -->
                        @foreach($stages as $key => $stage)
                        <div class="stage-item">
                            <div class="stage-icon">
                                <i class="kejar kejar-right"></i>
                            </div>
                            <div class="stage-text w-100">
                                <a href="{{ url('/students/games/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds') }}" class="text-link">
                                    <span class="stage-number">Babak {{ ++$key }} : </span><span class="text-wrap">{{ $stage['title'] }}</span>
                                </a>
                            </div>
                            <div class="stage-status-icon">
                                @if($stage['status'] == 'done')
                                <i class="kejar kejar-sudah-dikerjakan"></i>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endsection
