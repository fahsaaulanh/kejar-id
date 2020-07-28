@extends('layout.index')

@section('title', 'Daftar Babak - ' . $game['title'])

@section('content')
<div class="container">
        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('student/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('student/games') }}">Beranda</a>
            <span class="breadcrumb-item active">{{ $game['short'] }}</span>
        </nav>
        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{ $game['title'] }}</h2>
        </div>

        <!-- List of Stages (Student)-->
        <div class="list-group list-group-student">
            @forelse($stages as $stage)
            <div class="list-group-item">
                <a href="{{ url('student/games/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds') }}">
                    <i class="kejar-right"></i>
                    <span>Babak {{ $stage['order'] }} : </span> <span>{{ $stage['title'] }}</span>
                </a>
                <!-- <div class="hover-only"> -->
                    <div class="stage-order-buttons">
                        @if($stage['status'] == 'DONE')
                        <button class="btn-icon">
                            <i class="kejar-sudah-dikerjakan"></i>
                        </button>
                        @endif
                    </div>
                <!-- </div> -->
            </div>
            @empty
            <h5 class="text-center">Tidak ada data</h5>
            @endforelse
        </div>


    </div>
@endsection
