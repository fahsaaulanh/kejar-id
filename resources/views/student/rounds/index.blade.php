@extends('layout.index')

@section('title', 'Ronde Permainan')

@section('content')

<div class="container">
    <!-- Link Back -->
    <a class="btn-back" href="{{ url('/students/games/' . $game['uri'] . '/stages') }}">
        <i class="kejar-back"></i>Kembali
    </a>
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('students/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('/students/games/' . $game['uri'] . '/stages') }}">{{ $game['uri'] }}</a>
        <span class="breadcrumb-item active">{{ $stage['title'] }}</span>
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
            <a href="{{ url('students/games/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/'. $round['id'] . '/onboardings') }}">
                <i class="kejar-round"></i>
                <span>Ronde {{ ++$key }} : </span><span class="question-round"> {{ $round['title'] }}</span>
            </a>
            @if($round['score'] !== null)
                @if ($round['score'] == 100.00)
                    <div class="star-item">
                        <span class="star-icon active">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon active">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon active">
                            <i class="i-star"></i>
                        </span>
                    </div>
                @elseif ($round['score'] >= 75.00)
                    <div class="star-item">
                        <span class="star-icon active">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon active">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon">
                            <i class="i-star"></i>
                        </span>
                    </div>
                @elseif ($round['score'] >= 50.00)
                    <div class="star-item">
                        <span class="star-icon active">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon ">
                            <i class="i-star"></i>
                        </span>
                    </div>
                @elseif ($round['score'] < 50.00)
                    <div class="star-item">
                        <span class="star-icon">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon ">
                            <i class="i-star"></i>
                        </span>
                    </div>
                @endif
            @endif
            <!-- <div class="hover-only"> -->

            <div class="stage-order-buttons">
                <div class="play-button">
                    <a href="{{ url('students/games/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/'. $round['id'] . '/onboardings') }}" class="btn btn-next">
                        Mulai <i class="kejar-next"></i>
                    </a>
                </div>
            </div>
            <!-- </div> -->
        </div>
        @empty
        <h5 class="text-center">Tidak ada data</h5>
        @endforelse
    </div>

    <!-- <div class="list-group list-group-student">
        <p class="description">{{ $stage['description'] }}</p>
        <div class="round-list">
            @forelse ($rounds as $key => $round)
            <div class="round-list-item d-flex justify-content-between align-items-start">
                <div class="d-flex justify-content-start align-items-center">
                    <span class="flag-icon">
                        <i class="kejar-round"></i>
                    </span>
                    <a href="{{ url()->current() . '/' . $round['id'] . '/onboardings' }}">Ronde {{ ++$key }} :<span class="question-round"> {{ $round['title'] }}</span></a>
                </div>
                <div class="status-btn-group">
                    <div class="star-group">
                        <span class="star-icon active">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon active">
                            <i class="i-star"></i>
                        </span>
                        <span class="star-icon">
                            <i class="i-star"></i>
                        </span>
                    </div>
                    <a href="{{ url()->current() . '/' . $round['id'] . '/onboardings' }}" class="btn-play"><span>Main </span><span><i class="kejar-next"></i></span><span>.</span></a>
                </div>
            </div>
            @empty
            @endforelse
        </div> -->
</div>

@endsection