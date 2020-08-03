@extends('layout.index')

@section('title', 'Games ')

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
        @if($errors->has('round_file'))
            <script>
                alert("{{ $errors->first('round_file') }}");
            </script>
        @endif
        @if($errors->has('stage_file'))
            <script>
                alert("{{ $errors->first('stage_file') }}");
            </script>
        @endif
        @if (\Session::has('success'))
            <script>
                alert("{{ \Session::get('success') }}");
            </script>
        @endif
        <div class="upload-buttons">
            <button class="btn-upload" data-toggle="modal" data-target="#upload-stages">
                <i class="kejar-upload"></i>Unggah Babak
            </button>
            <button class="btn-upload" data-toggle="modal" data-target="#upload-rounds">
                <i class="kejar-upload"></i>Unggah Ronde
            </button>
        </div>

        <!-- List of Stages (Admin)-->
        <div class="list-group" data-url="{{ secure_url('admin/'. $game['uri'] . '/stages/') }}" data-token="{{ csrf_token() }}">
            @forelse ($stages as $stage)
            <div class="list-group-item" data-id="{{ $stage['id'] }}">
                <a href="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id']) }}/rounds">
                    <i class="kejar-link" data-id="{{ $stage['id'] }}" data-toggle="popover" data-placement="top" data-content="ID disalin!"></i>
                    <span class="stage-number">Babak </span> : {{ $stage['title'] }}
                </a>
                @if ($stagesCount > 1)
                    <div class="stage-order-buttons">
                        <button class="btn-icon">
                            <i class="kejar-top"></i>
                        </button>
                        <button class="btn-icon">
                            <i class="kejar-bottom"></i>
                        </button>
                    </div>
                @endif
                <!-- </div> -->
            </div>
            @empty
                <h5 class="text-center">Tidak ada data</h5>
            @endforelse
        </div>

    </div>
@include('admin.stages._upload_stages')
@include('admin.stages._create_stage')
@include('admin.stages._upload_rounds')
@endsection


@push('script')
<script src="{{ mix('/js/admin/stage/script.js') }}"></script>
@endpush
