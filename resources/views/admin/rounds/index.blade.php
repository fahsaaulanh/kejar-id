@extends('layout.index')

@section('title', 'Daftar Ronde - ' . $stage['title'])

@section('content')
<div class="container">

    <div class="page-title">
        <a class="btn-back" href="{{ url('admin/' . $game['uri'] . '/stages') }}" class="btn-back">
            <i class="kejar-back"></i>Kembali
        </a>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('admin/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('admin/' . $game['uri'] . '/stages') }}">{{ $game['short'] }}</a>
            <span class="breadcrumb-item active" href="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/') }}">Babak {{ $stage['order'] }}</span>
        </nav>
        <h2 class="mb-08rem">{{ $stage['title'] }}</h2>
        <span class="copy-id" data-id="{{ $stage['id'] }}"  data-container="body" data-toggle="popover" data-placement="top" data-content="ID disalin!">Salid ID Babak</span>
    </div>

    <h5 class="mb-08rem">Deskripsi Babak</h5>
    <p class="mb-4rem">{{ $stage['description'] }}</p>
    @if($errors->has('error'))
        <script>
            alert("{{ $errors->first('error') }}");
        </script>
    @endif
    @if (\Session::has('success'))
        <script>
            alert("{!! \Session::get('success') !!}");
        </script>
    @endif
    @if (($game['uri'] !== 'soalcerita') && ($game['uri'] !== 'menulisefektif'))
    <div class="upload-buttons">
        <button class="btn-upload" data-toggle="modal" data-target="#uploadRoundModal">
            <i class="kejar-upload"></i>Unggah Ronde
        </button>
        <button class="btn-upload" data-toggle="modal" data-target="#upload_question">
            <i class="kejar-upload"></i>Unggah Soal
        </button>
    </div>
    @else
    <div class="">
        <button class="btn-upload" data-toggle="modal" data-target="#uploadRoundModal">
            <i class="kejar-upload"></i>Unggah Ronde
        </button>
    </div>
    @endif
    <div class="list-group" data-url="{{ secure_url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/order/update') }}" data-token="{{ csrf_token() }}">
        @forelse($rounds as $round)
        <div class="list-group-item" data-id="{{ $round['id'] }}">
            <a href="{{ url()->current() . '/' . $round['id'] }}">
                <div class="flex">
                    <div>
                        <i class="kejar-link" data-id="{{ $round['id'] }}" data-container="body" data-toggle="popover" data-placement="top" data-content="ID disalin!"></i>
                        <span class="order-number"></span> : 
                    </div>
                    <div>
                        {{ $round['title'] }}
                    </div>
                </div>
            </a>
            <div class="round-order-buttons">
                @if($round['status'] == 'PUBLISHED')
                <span class="btn-icon order-status">
                    <i class="kejar-sudah-dikerjakan"></i>
                </span>
                @else
                <span class="btn-icon order-status">
                    <i class="kejar-belum-mengerjakan-2"></i>
                </span>
                @endif
                <button type="button" class="btn-icon sort-up">
                    <i class="kejar-top"></i>
                </button>
                <button type="button" class="btn-icon sort-down">
                    <i class="kejar-bottom"></i>
                </button>
            </div>
        </div>
        @empty
        <h5 class="text-center">Tidak ada data</h5>
        @endforelse
    </div>
</div>

@include('admin.rounds._update_title')
@include('admin.rounds._update_description')
@include('admin.rounds._upload_rounds')
@include('admin.rounds._upload_questions')
@include('admin.rounds._create_round')

@endsection

@push('script')
<script src="{{ mix('/js/admin/round/script.js') }}"></script>
@endpush
