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
        <span class="copy-id" data-id="{{ $round['id'] }}" data-toggle="popover" data-placement="top" data-content="ID disalin!">Salin ID Ronde</span>
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

        <div class="page-description-item material editor-display">
            <h5>Materi</h5>
            <div>
                <pre class="{{ $round['material'] == 'Buat Materi' ? 'material-default' : '' }}">{!!$round['material']!!}</pre>
            </div>
        </div>

        <div class="page-description-item direction">
            <h5>Petunjuk Soal</h5>
            <p>{{$round['direction']}}</p>
        </div>
    </div>

    <div>
        <button class="btn-upload" data-toggle="modal" data-target="#create-menulis-efektif-question-modal">
            <i class="kejar-add"></i>Input Soal
        </button>
    </div>

    <!-- Table of questions -->
    <div class="table-questions border-top-none">
    @forelse($roundQuestionsData as $key => $question)
        @php
        $pageNum = request()->page ?? 1;
        $questionNum = (($pageNum * 20) - 20) + $key + 1;
        @endphp
        <div class="card type-isian-bahasa">
            <div class="card-header">
                <div>
                    <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-isian-bahasa"></i> <h5>Isian Bahasa</h5>
                </div>
                <div>
                    <button class="btn-edit" data-toggle="modal" data-target="#update-menulis-efektif-question-modal" data-url="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/' . $question['question_id']) }}">
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="editor-display">
                    {!! $question['question']['question'] !!}
                </div>
                <div class="question-answer-group">
                    <table class="question-answer-table">
                        @if(is_array($question['question']['answer']) === true)
                            @foreach($question['question']['answer'] as $answer)
                                <tr>
                                    <td><i class="kejar-soal-benar"></i></td>
                                    <td>{!! $answer !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td><i class="kejar-soal-benar"></i></td>
                                <td>{!! $question['question']['answer'] !!}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="explanation-group">
                    <strong>Pembahasan</strong>
                    <div class="editor-display">
                        {!! $question['question']['explanation'] !!}
                    </div>
                </div>
            </div>
        </div>
    @empty
        <strong>Belum ada soal</strong><br>
    @endforelse
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
            @for($i = 1; $i <= $roundQuestionsMeta['last_page']; $i++)
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

@include('admin.questions._rename_round')
@include('admin.questions._update_description')
@include('admin.questions._update_setting')
@include('admin.questions._update_material')
@include('admin.questions._update_direction')
@include('admin.questions.create._isian_bahasa')
@include('admin.questions.update._isian_bahasa')
@endsection

@push('script')
<script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
<script src="{{ mix('/js/admin/question/script.js') }}"></script>
@endpush