@extends('layout.index')

@section('title', 'Daftar Paket - ' . $game['title'])

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/admin/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/admin/games') }}">Beranda</a>
            <span class="breadcrumb-item active">{{ $game['short'] }}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{ $game['title'] }}</h2>
        </div>

        <!-- Upload Buttons -->
        <button class="btn-upload" data-toggle="modal" data-target="#create-package">
            <i class="kejar-add"></i>Tambah Paket
        </button>

        <!-- List of Packages (Admin)-->
        <div class="list-group" data-url="{{ url('admin/'. $game['uri'] . '/packages/') }}" data-token="{{ csrf_token() }}">
            @forelse ($packages as $package)
            <div class="list-group-item" data-id="{{ $package['id'] }}">
                <a href="{{ url('admin/' . $game['uri'] . '/packages/' . $package['id'] . '/units') }}">
                    <i class="kejar-link" data-id="{{ $package['id'] }}" data-toggle="popover" data-placement="top" data-content="ID disalin!"></i>
                    <span class="order-number"></span> {{ $package['title'] }}
                </a>
                @if (count($packages) > 1)
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
            @empty
                <h5 class="text-center">Tidak ada data</h5>
            @endforelse
        </div>

    </div>
@include('admin.packages._create_package')
@endsection


@push('script')
<script src="{{ mix('/js/admin/package/script.js') }}"></script>
@endpush
