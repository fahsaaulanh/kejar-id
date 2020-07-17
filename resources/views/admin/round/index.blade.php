@extends('layout.index')

@section('title', 'Ronde')

@section('content')
<div class="container">

    <div class="page-title">
        <a class="btn-back" href="{{ url('admin/' . $game['uri'] . '/stages') }}" class="btn-back">
            <i class="kejar-back"></i>Kembali
        </a>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('admin/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('admin/' . $game['uri'] . '/stages') }}">OBR</a>
            <span class="breadcrumb-item active" href="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/') }}">Babak {{ $stage['order'] }}</span>
        </nav>
        <h2 class="mb-08rem">{{ $stage['title'] }}</h2>
        <span class="copy-id" data-id="{{ $stage['id'] }}">Salid ID Babak</span>
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
    <div class="upload-buttons">
        <button class="btn-upload" data-toggle="modal" data-target="#uploadRoundModal">
            <i class="kejar-upload"></i>Unggah Ronde
        </button>
        <button class="btn-upload" data-toggle="modal" data-target="#upload_question">
            <i class="kejar-upload"></i>Unggah Soal
        </button>
    </div>

    <div class="list-group">
        @forelse($rounds as $round)
        <div class="list-group-item" data-id="{{ $round['id'] }}">
            <a href="{{ url()->current() . '/' . $round['id'] }}">
                <i class="kejar-ink" data-id="{{ $round['id'] }}" data-container="body" data-toggle="popover" data-placement="top" data-content="ID disalin!"></i>
                <span></span> : {{ $round['title'] }}
            </a>
            <div class="round-order-buttons">
                @if($round['status'] == 'PUBLISHED')
                <span class="btn-icon order-status">
                    <i class="kejar-sudah-dikerjakan"></i>
                </span>
                @else
                <span class="btn-icon order-status">
                    <i class="kejar-belum-mengerjakan1"></i>
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
        <div class="list-group-item">
            Tidak ada data
        </div>
        @endforelse
    </div>
</div>

@include('admin.round._upload_rounds')
@include('admin.round._upload_question')
@include('admin.round._create_round')

@endsection

@push('script')
<script>
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    $(document).on('click', '.kejar-ink', function(e) {
        e.preventDefault();
        var thisElement = $(this);
        var roundId = $(this).attr('data-id');
        setTimeout( function() {
            thisElement.popover('hide');
        }, 1000);
        textToClipboard(roundId);
    });

    $(document).on('click', '.copy-id', function() {
        var stageId = $(this).attr('data-id');
        textToClipboard(stageId);
    });

    $(document).on('change', 'input[name=excel_file]', function() {
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
        $('input[name=file_name]').val(filename);
    });

    $(document).on('change', 'input[name=question_file]', function() {
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
        $('input[name=question_name]').val(filename);
    });

    $(document).on('click', '.sort-up', function() {
        var this_id = $(this).parents('.list-group-item').attr('data-id');
        var to_id = $(this).parents('.list-group-item').prev().attr('data-id');
        var this_element = $(this).parents('.list-group-item')
        var to_element = $(this).parents('.list-group-item').prev();
        $.ajax({
            type: "POST",
            url: "{{ secure_url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/order/update') }}",
            data: {
                '_token' : '{{ csrf_token() }}',
                'this_id' : this_id,
                'to_id' : to_id
            },
            success:function(data){
                to_element.insertAfter(this_element);
                numberSortCheck();
                buttonSortCheck();
            }
        });
    });

    $(document).on('click', '.sort-down', function() {
        var this_id = $(this).parents('.list-group-item').attr('data-id');
        var to_id = $(this).parents('.list-group-item').next().attr('data-id');
        var this_element = $(this).parents('.list-group-item');
        var to_element = $(this).parents('.list-group-item').next();
        $.ajax({
            type: "POST",
            url: "{{ secure_url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/order/update') }}",
            data: {
                '_token' : '{{ csrf_token() }}',
                'this_id' : this_id,
                'to_id' : to_id
            },
            success:function(data){
                this_element.insertAfter(to_element);
                numberSortCheck();
                buttonSortCheck();
            }
        });
    });

    function textToClipboard (text) {
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
    }

    function buttonSortCheck()
    {
        $('.sort-up').each(function() {
            $(this).prop('hidden', false);
        });
        $('.sort-down').each(function() {
            $(this).prop('hidden', false);
        });
        $('.sort-up').first().prop('hidden', true);
        $('.sort-down').last().prop('hidden', true);
    }

    buttonSortCheck();

    function numberSortCheck()
    {
        $('.list-group-item a span').each(function(number) {
            number++;
            $(this).text('Ronde ' + number);
        });
    }

    numberSortCheck();

    $('#createRoundModal').on('show.bs.modal', function() {
        $('#uploadRoundModal').modal('hide');
    });

    $('#createRoundModal').on('hide.bs.modal', function() {
        $('#uploadRoundModal').modal('show');
    });
</script>
@endpush
