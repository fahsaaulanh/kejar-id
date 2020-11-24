@extends('layout.index')

@section('title', 'Daftar Unit - ' . $package['title'])

@section('content')
<div class="container">

    <div class="page-title">
        <div class="d-flex justify-content-between">
            <div>
                <a class="btn-back" href="{{ url('admin/' . $game['uri'] . '/packages') }}" class="btn-back">
                    <i class="kejar-back"></i>Kembali
                </a>
            </div>
            <div class="btn-after-before">
                <a href="@if($prevPackage !== NULL) {{ url('admin/' . $game['uri'] . '/packages/' . $prevPackage . '/units') }} @endif" class="{{ $prevPackage === NULL ? 'inactive' : 'active' }}"><i class="kejar-arrow-left"></i> Sebelumnya</a>
                <a href="@if($nextPackage !== NULL) {{ url('admin/' . $game['uri'] . '/packages/' . $nextPackage . '/units') }} @endif" class="{{ $nextPackage === NULL ? 'inactive' : 'active' }}">Selanjutnya <i class="kejar-arrow-right"></i></a>
            </div>
        </div>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('admin/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('admin/' . $game['uri'] . '/packages') }}">{{ $game['short'] }}</a>
            <span class="breadcrumb-item active" href="{{ url('admin/' . $game['uri'] . '/packages/' . $package['id'] . '/units/') }}">Paket {{ $package['order'] }}</span>
        </nav>
        <h2 class="mb-08rem edit-title">{{ $package['title'] }}</h2>
    </div>

    <h5 class="mb-08rem">Deskripsi Paket</h5>
    <pre class="mb-4rem edit-description">{{ $package['description'] }}</pre>
    <div class="">
        <button class="btn-upload" data-toggle="modal" data-target="#create-unit">
            <i class="kejar-add"></i> Buat Unit
        </button>
    </div>
    <div class="list-group" data-url="{{ url('admin/'. $game['uri'] . '/packages/' . $package['id'] . '/units/order') }}" data-token="{{ csrf_token() }}">
        @forelse($units as $unit)
        <div class="list-group-item" data-id="{{ $unit['id'] }}">
            <a href="{{ url()->current() . '/' . $unit['id'] }}">
                <div>
                    <div>
                        <i class="kejar-link" data-id="{{ $unit['id'] }}" data-container="body" data-toggle="popover" data-placement="top" data-content="ID disalin!"></i>
                        <span class="order-number"></span> 
                    </div>
                    <div>
                        {{ $unit['title'] }}
                    </div>
                </div>
            </a>
            <div class="round-order-buttons">
                @if($unit['status'] == 'PUBLISHED')
                <span class="btn-icon order-status">
                    <i class="kejar-sudah-dikerjakan"></i>
                </span>
                @else
                <span class="btn-icon order-status">
                    <i class="kejar-belum-mengerjakan-2"></i>
                </span>
                @endif
                @if (count($units) > 1)
                    <div class="list-group-order-buttons">
                        <button class="btn-icon btn-icon-top">
                            <i class="kejar-top"></i>
                        </button>
                        <button class="btn-icon btn-icon-bottom">
                            <i class="kejar-bottom"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <h5 class="text-center">Tidak ada data</h5>
        @endforelse
    </div>
</div>

@include('admin.units._update_title')
@include('admin.units._update_description')
@include('admin.units._create_unit')
@endsection

@push('script')
<script src="{{ mix('/js/admin/unit/script.js') }}"></script>
@endpush