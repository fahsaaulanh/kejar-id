@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ url('/assets/css/ronde.css') }}">
<link rel="stylesheet" href="{{ url('/assets/css/admin/modal/modal.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center content">
        <div class="col-md-10 col-lg-6">
            <!-- Link Back -->
            <div class="d-flex justify-content-between top-link align-items-center">
                <div class="link-back">
                    <a href="{{ url($game['uri'] . '/' . $stageId) }}" class="text-link d-flex align-items-center">
                        <i class="kejar kejar-arrow-left"></i> <span class="ml-2">Kembali</span>
                    </a>
                </div>
                <div>
                    <button data-status="{{ $round['status'] }}" id="btn-status" class="btn {{ $round['status'] === 'PUBLISHED' ? 'btn-light btn-revise' : 'btn-primary btn-publish' }} btn-status">{{ $round['status'] === 'PUBLISHED' ? 'Revisi' : 'Terbitkan' }}</button>
                </div>
            </div>
            <!-- Breadcrumb -->
            <nav class="breadcrumb bg-transparent p-0">
                <a class="breadcrumb-item" href="{{ url('/') }}">Beranda</a>
                <a class="breadcrumb-item" href="{{ url($game['uri']) }}">{{ $game['short'] }}</a>
                <a class="breadcrumb-item" href="{{ url($game['uri'] . '/' . $stageId) }}">{{ $stage['title'] }}</a>
                <span class="breadcrumb-item active">{{ $round['title'] }}</span>
            </nav>
            <!-- Title -->
            <h1 class="text-title">{{ $round['title'] }}</h1>
            <span class="copy-link-id" onclick="copyToClipboard('{{ $round['id'] }}')">Salin link ID</span>
            <!-- Round Detail -->
            <div class="round-detail-group">
                <div class="round-detail">
                    <h5 class="round-detail-title">Pengaturan Ronde</h5>
                    <p>{{ $round['description'] }}</p>
                </div>
                <div class="round-detail">
                    <h5 class="round-detail-title">Deskripsi Ronde</h5>
                    <p>{{ $round['description'] }}</p>
                </div>
                <div class="round-detail">
                    <h5 class="round-detail-title">Materi</h5>
                    <p>
                        @if($round['material'] == null)
                        <a href="#" class="link-create-materi">Buat Materi</a>
                        @else
                        {{ $round['material'] }}
                        @endif
                    </p>
                </div>
                <div class="round-detail">
                    <h5 class="round-detail-title">Petunjuk Soal</h5>
                    <p>{{ $round['direction'] }}</p>
                </div>
            </div>
            <!-- Modal Buttons -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <button class="btn btn-md btn-modal btn-block" data-toggle="modal" data-target="#upload_question">
                        <i class="kejar kejar-upload"></i> Unggah Soal
                    </button>
                    @if($errors->has('ronde_file'))
                        <div class="error text-danger">{{ $errors->first('ronde_file') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <button class="btn btn-md btn-modal btn-block" data-toggle="modal" data-target="#createQuestionModal">
                        <i class="kejar kejar-add"></i> Input Soal
                    </button>
                </div>
            </div>
            <!-- Table of Questions -->
            <div class="table-responsive-md table-questions">
                <table class="table table-md table-stripped">
                    <thead>
                        <th class="w-50">Soal</th>
                        <th class="w-50">Jawaban</th>
                    </thead>
                    <tbody>
                        @forelse($roundQuestionsData as $question)
                        <tr>
                            <td class="align-middle">${{ $question['question']['question'] }}$</td>
                            <td class="align-middle">{{ $question['question']['answer'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-secondary">Belum ada soal</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="pagination-detail">{{ $roundQuestionsMeta['to'] ?? 0 }} dari {{ $roundQuestionsMeta['total'] }} soal</span>
                </div>
                <nav>
                    <ul class="pagination my-auto">
                        <li class="page-item {{ $roundQuestionsMeta['current_page'] == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="?page={{ $roundQuestionsMeta['current_page'] - 1 }}" aria-label="Previous">
                                <span aria-hidden="true"><i class="kejar kejar-left"></i></span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        @for ($x = 1; $x <= $roundQuestionsMeta['last_page']; $x++)
                            @if($roundQuestionsMeta['total'] > 0)
                                <li class="page-item {{ $roundQuestionsMeta['current_page'] == $x ? 'active' : '' }}"><a class="page-link" href="?page={{$x}}">{{ $x }}</a></li>
                            @endif
                        @endfor
                        <li class="page-item {{ $roundQuestionsMeta['current_page'] >= $roundQuestionsMeta['last_page'] ? 'disabled' : '' }}">
                            <a class="page-link" href="?page={{ $roundQuestionsMeta['current_page'] + 1 }}" aria-label="Next">
                                <span aria-hidden="true"><i class="kejar kejar-right"></i></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection

@include('admin.question._upload_questions')
@include('admin.question._create_question')
@include('admin.question._rename_round')
@include('admin.question._update_description')
@include('admin.question._update_setting')
@include('admin.question._update_material')

@section('scripts')
<script>

    // Choose file script
    $(document).on('change', 'input[name=question_file]', function(){
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
        filename = filename == '' ? 'Pilih file' : filename;
        $('input[name=question_name]').val(filename);
    });

    // copy id
    function copyToClipboard(text) {
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
    }

    // Updating Status
    $(document).on('click', '#btn-status', function(){
       var status = $(this).data('status');
       var el = $(this);
       var statusUpdate = status == 'PUBLISHED' ? 'NOT_PUBLISHED' : 'PUBLISHED';
       $.ajax({
           type: "POST",
           url: "{{ url('admin/' . $game['uri'] . '/stages/'. $stageId .'/rounds/'. $roundId .'/status') }}",
           data: {
               "_token": "{{ csrf_token() }}",
               "_method": "PATCH",
               'status': statusUpdate
           },
           dataType: "JSON",
           success: function (response) {
                $(el).text(function(i, text){
                    return text === "Revisi" ? "Terbitkan" : "Revisi";
                })
                $('#btn-status').toggleClass('btn-primary btn-publish btn-light btn-revise');
           }
       });
    });
</script>
@endsection
