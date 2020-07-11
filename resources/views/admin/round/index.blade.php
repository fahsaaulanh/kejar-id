@extends('../../layout/main')

@section('css')
<link href="{{ asset('assets/css/admin/round/style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="uploadRoundModal" tabindex="-1" role="dialog" aria-labelledby="uploadRoundModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadRoundModalLabel">Unggah Ronde</h5>
                            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                            <i class="kejar-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" class="form-control form-custom-input" value="Pilih File" name="file_name" disabled="">
                                    <input type="file" name="excel_file" accept=".xls, .xlsx" hidden="">
                                </div>
                                <div class="col-4 mar-lef-min">
                                    <button type="button" class="btn-modal btn-choose-file">
                                        Pilih File
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <a href="https://docs.google.com/spreadsheets/d/1Ql1X_7JOEauVTLbs8qHZdT2SeV-sr2jQfufXTeiFrI8/edit?usp=sharing" target="_blank" class="btn-download-format"><i class="kejar-download"></i> Download Format</a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn-modal btn-make-round">
                                <i class="kejar-add"></i> Buat Ronde
                            </button>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn-modal btn-cancel-upload" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn-modal btn-upload-round ml-2">Unggah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="content">
            <div class="content-header">
                <a href="{{ url('admin/' . $game['uri'] . '/stages') }}" class="btn-back row align-items-center">
                    <div class="row  align-items-center">
                        <i class="kejar-arrow-left"></i>
                         <p style="margin: 0 0 0 0">Kembali</p>
                        </div>
                </a>
                <ul class="breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin/' . $game['uri'] . '/stages') }}">OBR</a></li>
                    <li class="breadcrumb-item active"><a href="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/') }}">Babak 1</a></li>
                </ul>
                <h2 class="title-round">{{ $stage['title'] }}</h2>
                <button class="btn-round-id" data-id="{{ $stage['id'] }}" type="button">Salid ID Babak</button>
            </div>
            <div class="content-body">
                <h5 class="title-description">Deskripsi Babak</h5>
                <p class="description">{{ $stage['description'] }}</p>
                <div class="btn-group-action row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 mar-bot">
                        <button type="button" class="btn-upload btn-block" data-toggle="modal" data-target="#uploadRoundModal">
                            <i class="kejar-download"></i>
                                Unggah Ronde
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <button type="button" class="btn-upload btn-block" data-toggle="modal" data-target="#upload_question">
                            <i class="kejar-download"></i>
                                Unggah Soal
                        </button>
                    </div>
                </div>
                <div class="round-list">
                    @if($rounds != '')
                    @foreach($rounds as $round)
                    <div class="round-list-item d-flex justify-content-between align-items-center" data-id="{{ $round['id'] }}">
                        <div class="d-flex justify-content-start align-items-center">
                            <button class="btn-clipboard" type="button" data-id="{{ $round['id'] }}">
                                <i class="kejar-ink"></i>
                            </button>
                            <a href="{{ url()->current() . '/' . $round['id'] . '/questions' }}" class="round-list"><span>Ronde {{ $loop->iteration }}</span>: {{ $round['title'] }}</a>
                        </div>
                        <div class="btn-group-sort">
                            @if($round['status'] == 'PUBLISHED')
                            <span class="icon-status">
                                <i class="kejar-sudah-dikerjakan"></i>
                            </span>
                            @else
                            <span class="icon-status">
                                <span class="alert-icon">!</span>
                                <i class="kejar-belum-mengerjakan"></i>
                            </span>
                            @endif
                            <button class="btn-sort sort-up">
                                <i class="kejar-arrow-right"></i>
                            </button>
                            <button class="btn-sort sort-down">
                                <i class="kejar-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="round-list-item d-flex justify-content-start align-items-center">
                        Tidak ada data
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('modals/_upload_question')

@push('script')
<script>
    $(document).on('click', '.btn-round-id, .btn-clipboard', function(){
        var id_round = $(this).attr('data-id');
        textToClipboard(id_round);
    });

    $(document).on('click', '.btn-choose-file', function(){
        $('input[name=excel_file]').click();
    });

    $(document).on('change', 'input[name=excel_file]', function(){
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
        $('input[name=file_name]').val(filename);
    });

    $(document).on('click', '.sort-up', function(){
        var this_id = $(this).parent().parent().attr('data-id');
        var to_id = $(this).parent().parent().prev().attr('data-id');
        var this_text = $(this).parent().prev().children('a').children().first().text();
        var to_text = $(this).parent().parent().prev().children().first().children('a').children().first().text();
        $(this).parent().parent().attr('data-id', to_id);
        $(this).parent().parent().prev().attr('data-id', this_id);
        $(this).parent().prev().children('a').children().first().html(to_text);
        $(this).parent().parent().prev().children().first().children('a').children().first().html(this_text);
        $(this).parent().parent().prev().insertAfter($(this).parent().parent());
        buttonSortCheck();
        $.ajax({
            type: "POST",
            url: "{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/order/update') }}",
            data: {
                '_token' : '{{ csrf_token() }}',
                'this_id' : this_id,
                'to_id' : to_id
            },
            dataType: "JSON",
            success:function(data){
                console.log(data);
            }
        });
    });

    $(document).on('click', '.sort-down', function(){
        var this_id = $(this).parent().parent().attr('data-id');
        var to_id = $(this).parent().parent().next().attr('data-id');
        var this_text = $(this).parent().prev().children('a').children().first().text();
        var to_text = $(this).parent().parent().next().children().first().children('a').children().first().text();
        $(this).parent().parent().attr('data-id', to_id);
        $(this).parent().parent().next().attr('data-id', this_id);
        $(this).parent().prev().children('a').children().first().html(to_text);
        $(this).parent().parent().next().children().first().children('a').children().first().html(this_text);
        $(this).parent().parent().insertAfter($(this).parent().parent().next());
        buttonSortCheck();
        $.ajax({
            type: "POST",
            url: "{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/order/update') }}",
            data: {
                '_token' : '{{ csrf_token() }}',
                'this_id' : this_id,
                'to_id' : to_id
            },
            dataType: "JSON",
            success:function(data){
                console.log(data);
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

    function buttonSortCheck(){
        $('.sort-up').each(function(){
            $(this).prop('hidden', false);
        });
        $('.sort-down').each(function(){
            $(this).prop('hidden', false);
        });
        $('.sort-up').first().prop('hidden', true);
        $('.sort-down').last().prop('hidden', true);
    }

    buttonSortCheck();
</script>
@endpush
