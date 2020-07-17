@extends('layout.index')

@section('title', 'Questions')

@section('content')

<div class="container">

    <!-- Link Back -->
    <div class="px-3 row align-items-center justify-content-between">
        <a class ="btn-back" href="{{ url('/admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <button class="{{ $round['status'] == 'PUBLISHED' ? 'btn-revise' : 'btn-publish'}}" onclick="document.getElementById('update-status-form').submit();">
            {{ $round['status'] == 'PUBLISHED' ? 'Revisi' : 'Terbitkan'}}
        </button>
        <form action="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id']) }}" method="post" id="update-status-form" class="d-none">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="{{ $round['status'] == 'PUBLISHED' ? 'NOT_PUBLISHED' : 'PUBLISHED' }}">
        </form>
    </div>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/admin/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('/admin/' . $game['uri'] . '/stages') }}">{{ $game['short'] }}</a>
        <a class="breadcrumb-item" href="{{ url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds') }}">Babak {{ $stage['order'] }}</a>
        <span class="breadcrumb-item active">Ronde {{ $round['order'] }}</span>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">{{ $round['title'] }}</h2>
        <span class="copy-id" onclick="textToClipboard('{{ $round['id'] }}')" data-toggle="popover" data-placement="top" data-content="ID disalin!">Salin ID Ronde</span>
    </div>

    <!-- Description -->
    <div class="page-description">
        <div class="page-description-item setting">
            <h5>Pengaturan Ronde</h5>
            <p>{{$round['total_question']}} soal ditampilkan &bullet; {{$round['question_timespan']}} detik/soal</p>
        </div>

        <div class="page-description-item description">
            <h5>Deskripsi Ronde</h5>
            <p>{{$round['description']}}</p>
        </div>

        <div class="page-description-item material">
            <h5>Materi</h5>
            <p class="{{ $round['material'] == 'Buat Materi' ? 'material-default' : '' }}">{{$round['material']}}</p>
        </div>

        <div class="page-description-item direction">
            <h5>Petunjuk Soal</h5>
            <p>{{$round['direction']}}</p>
        </div>
    </div>

    <!-- Upload Buttons -->
    @if($errors->has('question_file'))
        <script>
            alert("{{ $errors->first('question_file') }}");
        </script>
    @endif
    <div class="upload-buttons">
        <button class="btn-upload" data-toggle="modal" data-target="#upload-questions">
            <i class="kejar-upload"></i>Unggah Soal
        </button>
        <button class="btn-upload" data-toggle="modal" data-target="#create-question">
            <i class="kejar-add"></i>Input Soal
        </button>
    </div>

    <!-- Table of questions -->
    <div class="table-responsive">
        <table class="table table-stripped table-questions">
            <thead>
                <th>Soal</th>
                <th>Jawaban</th>
            </thead>
            <tbody>
                @forelse($roundQuestionsData as $question)
                <tr data-id="{{ $question['question']['id'] }}" data-question="{{ $question['question']['question'] }}" data-answer="{{ $question['question']['answer'] }}">
                    <td>{{ $question['question']['question'] }}</td>
                    <td>{{ $question['question']['answer'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">Belum ada soal</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <nav class="navigation">
        <div>
            <span class="pagination-detail">{{ $roundQuestionsMeta['to'] ?? 0 }} dari {{ $roundQuestionsMeta['total'] }} soal</span>
        </div>
        <ul class="pagination">
            <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
            </li>
            @for($i=1; $i <= $roundQuestionsMeta['last_page']; $i++)
            <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
            </li>
            @endfor
            <li class="page-item {{ ((request()->page ?? 1) + 1) > $roundQuestionsMeta['last_page'] ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
            </li>
        </ul>
    </nav>

</div>

@include('admin.questions._upload_questions')
@include('admin.questions._create_question')
@include('admin.questions._rename_round')
@include('admin.questions._update_description')
@include('admin.questions._update_setting')
@include('admin.questions._update_material')
@include('admin.questions._update_direction')
@include('admin.questions._update_question')
@endsection

@push('script')

<script>

    $('#upload-questions').on('show.bs.modal', event => {
        $('#create-question').modal('hide');
    });

    $('#create-question').on('show.bs.modal', event => {
        $('#upload-questions').modal('hide');
    });

    $(document).on('click', '.btn-add', function(){
        var index = $('.table-form tbody tr').length;

        $('.table-form').find('tbody').append('<tr><td><input type="text" placeholder="Ketik soal" name="question[' + index + '][question]" class="form-control"></td><td><input type="text" placeholder="Ketik jawaban" name="question['+ index +'][answer]" class="form-control"></td></tr>');
    });

    $(document).on('change', 'input[type=file]', function(){
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');

        filename = filename == '' ? 'Pilih file' : filename;
        $(this).parents('.custom-upload').find('input[type=text]').val(filename);
    });

    $('[data-toggle="popover"]').popover();

    function textToClipboard (text) {
        event.preventDefault();
        setTimeout(() => {
            $('[data-toggle="popover"]').popover('hide');
        }, 1000);
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
    }

    // Editing

    $('.page-title h2').dblclick(function() {
        $('#rename-round').modal('show');
    });

    $('.description').dblclick(function() {
        $('#update-description').modal('show');
    });

    $('.setting').dblclick(function() {
        $('#update-setting').modal('show');
    });

    $('.material').dblclick(function() {
        $('#update-material').modal('show');
    });

    $('.direction').dblclick(function() {
        $('#update-direction').modal('show');
    });

    $('.table-questions tbody tr').on('dblclick', 'td', function() {
        var modal = $('#update-question');
        var id = $(this).parent().data('id');
        var question = $(this).parent().data('question');
        var answer = $(this).parent().data('answer');
        url = "{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/') }}/" + id;
        $(modal).find('form').attr('action', url);
        $(modal).find('input[name="question"]').val(question);
        $(modal).find('input[name="answer"]').val(answer);
        $(modal).modal('show');
    });

</script>

@endpush
