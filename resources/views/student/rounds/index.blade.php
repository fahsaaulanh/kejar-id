@extends('layout.index')

@section('title', 'Daftar Ronde - ' . $stage['title'])

@section('content')

<div class="container">
    <!-- Link Back -->
    <a class="btn-back" href="{{ url('student/games/' . $game['uri'] . '/stages') }}">
        <i class="kejar-back"></i>Kembali
    </a>
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('student/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('student/games/' . $game['uri'] . '/stages') }}">{{ $game['short'] }}</a>
        <span class="breadcrumb-item active">Babak {{ $stage['order'] }}</span>
    </nav>
    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">{{ $stage['title'] }}</h2>
    </div>

    <!-- List of Stages (Student)-->

    <div class="list-group list-group-student">
        <p class="description">{{ $stage['description'] }}</p>
        @forelse ($rounds as $key => $round)
        <div class="list-group-item">
            <a href="{{ url('student/games/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/'. $round['id'] . '/onboardings') }}">
                <i class="kejar-round"></i>
                <span>Ronde {{ $round['order'] }} : </span><span class="question-round"> {{ $round['title'] }}</span>
            </a>
            @if($round['score'] !== null)
                @if ($round['score'] == 100.00)
                    <div class="star-item">
                        <span class="star-icon active">
                            <i class="kejar-arsip-asesmen-bold active"></i>
                        </span>
                        <span class="star-icon active">
                            <i class="kejar-arsip-asesmen-bold active"></i>
                        </span>
                        <span class="star-icon active">
                            <i class="kejar-arsip-asesmen-bold active"></i>
                        </span>
                    </div>
                @elseif ($round['score'] >= 75.00)
                    <div class="star-item">
                        <span class="star-icon active">
                            <i class="kejar-arsip-asesmen-bold active"></i>
                        </span>
                        <span class="star-icon active">
                            <i class="kejar-arsip-asesmen-bold active"></i>
                        </span>
                        <span class="kejar-arsip-asesmen">
                            <i class="i-star"></i>
                        </span>
                    </div>
                @elseif ($round['score'] >= 50.00)
                    <div class="star-item">
                        <span class="kejar-arsip-asesmen-bold active">
                            <i class="i-star"></i>
                        </span>
                        <span class="kejar-arsip-asesmen">
                            <i class="i-star"></i>
                        </span>
                        <span class="kejar-arsip-asesmen ">
                            <i class="i-star"></i>
                        </span>
                    </div>
                @elseif ($round['score'] < 50.00)
                    <div class="star-item">
                        <span class="kejar-arsip-asesmen">
                            <i class="i-star"></i>
                        </span>
                        <span class="kejar-arsip-asesmen">
                            <i class="i-star"></i>
                        </span>
                        <span class="kejar-arsip-asesmen ">
                            <i class="i-star"></i>
                        </span>
                    </div>
                @endif
            @endif
            <!-- <div class="hover-only"> -->

            <div class="stage-order-buttons">
                <div class="play-button">
                    <a href="{{ url('student/games/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/'. $round['id'] . '/onboardings') }}" class="btn-next">
                        Main <i class="kejar-next"></i>
                    </a>
                </div>
            </div>
            <!-- </div> -->
        </div>
        @empty
        <h5 class="text-center">Tidak ada data</h5>
        @endforelse
    </div>
</div>

@endsection
