@extends('layout.index')

@section('title', 'Daftar Rombel - ' . $game['title'])

@section('content')

    <div class="container">
        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teachers/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teachers/games') }}">Beranda</a>
            <span class="breadcrumb-item active">Daftar Rombel</span>
        </nav>
        <!-- Title -->
        <div class="page-title mb-6rem">
            <h2>{{ $game['title'] }}</h2>
        </div>

        <!-- List of class-->
        @if ($classCount['count_x'] > 0)
            <h5 class="title-class">Kelas 10</h5>
            <div class="list-group">
                @foreach ($classList as $class)
                @if ($class['class_grade'] === 'X')
                <div class="list-group-item">
                    <a href="{{ url('/teachers/games/' . $game['uri'] . '/class/' . $class['class_batch_id'] . '/' . $class['class_id'] . '/stages') }}">
                        <i class="kejar-right"></i>
                        {{ $class['class_name'] }}
                    </a>
                </div>
                @endif
                @endforeach
            </div>
        @endif
        @if ($classCount['count_xi'] > 0)
            <h5 class="title-class">Kelas 11</h5>
            <div class="list-group">
                @foreach ($classList as $class)
                @if ($class['class_grade'] === 'XI')
                <div class="list-group-item">
                    <a href="{{ url('/teachers/games/' . $game['uri'] . '/class/' . $class['class_batch_id'] . '/' . $class['class_id'] . '/stages') }}">
                        <i class="kejar-right"></i>
                        {{ $class['class_name'] }}
                    </a>
                </div>
                @endif
                @endforeach
            </div>
        @endif
        @if ($classCount['count_xii'] > 0)
            <h5 class="title-class">Kelas 12</h5>
            <div class="list-group">
                @forelse ($classList as $class)
                @if ($class['class_grade'] === 'XII')
                <div class="list-group-item">
                    <a href="{{ url('/teachers/games/' . $game['uri'] . '/class/' . $class['class_batch_id'] . '/' . $class['class_id'] . '/stages') }}">
                        <i class="kejar-right"></i>
                        {{ $class['class_name'] }}
                    </a>
                </div>
                @endif
                @endforeach
            </div>
        @endif
    </div>

@endsection
