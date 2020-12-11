@extends('layout.index')

@section('title', 'TOEIC')

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
        {{-- Peraturan Ronde --}}
        <div class="page-description-item setting">
            <h5>Pengaturan Ronde</h5>
            <p>{{$round['total_question']}} soal ditampilkan &bullet; {{$round['question_timespan']}} detik/soal</p>
        </div>
        {{-- Deskripsi Ronde --}}
        <div class="page-description-item description">
            <h5>Deskripsi Ronde</h5>
            <pre>{{$round['description']}}</pre>
        </div>
        {{-- Materi --}}
        <div class="page-description-item material editor-display">
            <h5>Materi</h5>
            <div>
                <pre class="{{ $round['material'] == 'Buat Materi' ? 'material-default' : '' }}">{!! $round['material'] !!}</pre>
            </div>
        </div>
        {{-- Petunjuk soal --}}
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
        {{-- button unggah soal --}}
        <button class="btn-upload" data-toggle="modal" data-target="#upload-questions">
            <i class="kejar-upload"></i>Unggah Soal
        </button>
        {{-- button Input Soal --}}
        <button class="btn-upload" data-toggle="modal" data-target="#create-question">
            <i class="kejar-add"></i>Input Soal
        </button>
    </div>

    <!-- Table of questions -->
    <div class="table-responsive">
        <table class="table table-toeic">
            <thead>
                <th class="a">Meaning</th>
                <th class="b">Word</th>
            </thead>
            <tbody class="pointer">
                @forelse($roundQuestionsData as $question)
                <tr data-id="{{ $question['question']['id'] }}" data-question="{{ $question['question']['question'] }}" data-answer="{{ $question['question']['answer'] }}" data-url="{{ secure_url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/' . $question['question_id']) }}">
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
            @php
                $x = $roundQuestionsMeta['current_page'] < 3 ? 1 : $roundQuestionsMeta['current_page'] - 2;
                $y = $roundQuestionsMeta['current_page'] + 2 < $roundQuestionsMeta['last_page'] ? $roundQuestionsMeta['current_page'] + 2 : $roundQuestionsMeta['last_page'];
            @endphp
            @for($i= $x; $i <= $y; $i++)
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
@include('admin.questions.create._isian_singkat')
@include('admin.questions.update._isian_singkat')
@include('admin.questions._rename_round')
@include('admin.questions._update_description')
@include('admin.questions._update_setting')
@include('admin.questions._update_material')
@include('admin.questions._update_direction')
@endsection

@push('script')
    <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
    <script src="{{ mix('/js/admin/question/script.js') }}"></script>
@endpush
