@extends('layout.main')

@section('css')
<link rel="stylesheet" href="{{ url('/assets/css/round/userRound.css') }}">
@endsection

@section('content')

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="content">
                        <div class="content-header">
                            <a href="{{ url('/stages') }}" class="btn-back">
                                <i class="kejar-arrow-left"></i>
                                 Kembali
                            </a>
                            <ul class="breadcrumb-custom">
                                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/student/' . $game['uri'] . '/stages') }}">{{ $game['uri'] }}</a></li>
                                <li class="breadcrumb-item active"><a href="#">{{ $stage['title'] }}</a></li>
                            </ul>
                            <h2 class="title-round">{{ $stage['title'] }}</h2>
                        </div>
                        <div class="content-body">
                            <p class="description">{{ $stage['description'] }}</p>
                            <div class="round-list">
                            @forelse ($rounds as $key => $round)
                                <div class="round-list-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <span class="flag-icon">
                                            <i class="kejar-round"></i>
                                        </span>
                                        <a href="#">Ronde {{ ++$key }} :<span class="question-round"> {{ $round['title'] }}</span></a>
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
                                        <a href="#" class="btn-play"><span>Main </span><span><i class="kejar-next"></i></span><span>.</span></a>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
