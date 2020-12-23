@extends('layout.index')

@section('title', ucfirst($type).': Kelas '.$grade.' - '.$subject['name'].' - '.$assessmentGroup)

@section('content')
<div class="container">

    <!-- Link Back -->
    <a class="btn-back" href="{{ url('/teacher/subject-teacher/'.$assessmentGroupId.'/subject') }}">
        <i class="kejar-back"></i>Kembali
    </a>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('/teacher/subject-teacher/'.$assessmentGroupId.'/subject') }}">{{$assessmentGroup}}</a>
        <span class="breadcrumb-item active">{{$subject['name']}}</span>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">Kelas {{$grade}}</h2>
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

    @if(count($assessments) == 0)
        <div class="row">
            <div class="col-sm-6">
                <button class="btn-upload mb-0" data-toggle="modal" data-target="#add-ma" onclick="setType('MINI_ASSESSMENT')">
                    <i class="kejar-upload"></i>Unggah Naskah
                </button>
            </div>
            <div class="col-sm-6">
                <button class="btn-upload mb-0" onclick="setAdd('{{$assessmentGroupId}}', '{{$subject['id']}}', '{{$grade}}')">
                    <i class="kejar-add"></i>Input Soal
                </button>
                <div class="mt-3" id="LoadingAssess4" style="display:none">
                    <div class="row justify-content-center">
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan...</span>
                        </div>
                    </div>
                    <div class="mt-2 row justify-content-center">
                        <h5>Sedang Membuat assessment</h5>
                    </div>
                </div>
            </div>
        </div>
    @else
        <button class="btn btn-publish font-15" onclick="modalAssignShow(1)">
            <i class="kejar-siswa"></i>Tugaskan Siswa
        </button>
    @endif
    @if(count($assessments) == 0)
        <h3 class="mt-8 mb-4">Unggah Naskah vs Input Nilai</h3>
        <h5 class="text-grey-3 text-reguler">
            Bapak/Ibu Guru, berikut adalah perbedaan antara Unggah Naskah dan Input Soal sebagai pertimbangan dalam memilih bentuk Penilaian.
        </h5>
        <div class="table-responsive table-result-stage">
            <table class="table table-bordered table-normal">
                <thead>
                    <tr>
                        <th style="width: 11.1rem!important">Perbedaan</th>
                        <th style="width: 28.2rem!important;text-align: left!important">Unggah Naskah</th>
                        <th style="width: 27.9rem!important">Input Soal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Yang Diinput</td>
                        <td>
                            Naskah soal berbentuk PDF (sekaligus semua soal).
                            <br />
                            <br />
                            Sebaiknya guru menginput beberapa paket soal dengan tingkat kesulitan yang sama.
                        </td>
                        <td>
                            Soal diinput satu per satu.
                            <br />
                            <br />
                            Hanya bisa ada satu alternatif soal untuk setiap nomor.
                        </td>
                    </tr>
                    <tr>
                        <td>Tipe Soal</td>
                        <td>Pilihan Ganda.</td>
                        <td>Pilihan Ganda.</td>
                    </tr>
                    <tr>
                        <td>Yang Dikerjakan Siswa</td>
                        <td>Salah satu paket soal secara acak.</td>
                        <td>Semua soal yang diinputkan. Urutan nomor diacak.</td>
                    </tr>
                    <tr>
                        <td>Kelebihan</td>
                        <td>
                            - Lebih efisien ketika menginput soal (cukup mengunggah naskah).<br />
                            - Siswa membutuhkan kuota relatif lebih sedikit untuk mengerjakan.<br />
                            - Setiap paket dapat memiliki soal berbeda.
                        </td>
                        <td>
                            - Soal yang diinputkan tersimpan ke dalam bank soal.<br />
                            - Siswa hanya membutuhkan satu layar untuk mengerjakan.<br />
                        </td>
                    </tr>
                    <tr>
                        <td>Kekurangan</td>
                        <td>
                            - Siswa membutuhkan dua layar untuk mengerjakan.<br />
                            - Soal tidak tersimpan ke bank soal.
                        </td>
                        <td>
                            - Waktu yang dibutuhkan untuk menginput soal lebih lama.<br />
                            - Semua siswa mendapatkan soal yang sama meskipun teracak urutannya.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <ul class="nav nav-justified nav-tab-kejar  mt-8" id="myTab" role="tablist">
            <li class="nav-item w-50 text-center" role="presentation">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Penugasan dan Nilai</a>
            </li>
            <li class="nav-item w-50 text-center" role="presentation">
                <a class="nav-link active" id="packgae-tab" data-toggle="tab" href="#packgae" role="tab" aria-controls="packgae" aria-selected="false">Soal</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="mt-8">
                    <div>
                        <a href="{{ URL('teacher/subject-teacher/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment/status-task/Undone') }}" class="text-black-1 text-decoration-none">
                            <div class="w-100 bg-grey-15 mb-4 px-4 py-3">
                                <i class="kejar-rombel"></i> Siswa Belum Mengerjakan (Semua Rombel)
                            </div>
                        </a>
                    </div>
                    @foreach($studentGroup as $data)
                        <div>
                            <a href="{{ URL('teacher/subject-teacher/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment/student-group/'.$data['id'].'/score') }}" class="text-black-1 text-decoration-none">
                                <div class="w-100 bg-grey-15 mb-4 px-4 py-3">
                                    <i class="kejar-rombel"></i> Rombel {{$data['name']}}
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade show active" id="packgae" role="tabpanel" aria-labelledby="packgae-tab">
                @if($newestPackStatus !== "" && $type === "MINI_ASSESSMENT")
                <div class="answer-note text-grey-3 mt-8" id="answer_status">
                    Input semua paket soal beserta kunci jawabannya sebelum menugaskan siswa.
                </div>
                @endif

                <div class="row mt-8 mb-3 align-items-center">
                    <div class="col">
                        <h3>Pengaturan</h3>
                    </div>
                    <div class="col col-sm-2">
                        @if($type === 'ASSESSMENT')
                        <button class="btn bg-white btn-revise" onclick="changeDurationModal()"><i class="kejar-setting"></i>Ubah</button>
                        @else
                        <button class="btn bg-white btn-revise" data-toggle="modal" data-target="#setting_pack"><i class="kejar-setting"></i>Ubah</button>
                        @endif
                    </div>
                </div>
                <div class="row mb-4">
                    @if(isset($assessments[0]['pdf_password']) == true)
                        <div class="col">
                            <h5>Token/Password PDF</h5>
                            <h5 class="text-reguler">{{($assessments[0]['pdf_password'] == null ? '-' : $assessments[0]['pdf_password'])}}</h5>
                        </div>
                    @endif
                    <div class="col">
                        <h5>Durasi</h5>
                        <h5 class="text-reguler">
                            <span id="duration-caption">{{($assessments[0]['duration'] == null ? '-' : $assessments[0]['duration'].' menit')}}
                            </span>
                        </h5>
                    </div>
                </div>

                @if(count($questions) > 0 && $type === "MINI_ASSESSMENT")
                <div class="row">
                    <div class="col">
                        <h5>Banyaknya Soal</h5>
                        <h5 class="text-reguler">{{count($questions).' soal'}}</h5>
                    </div>
                    <div class="col">
                        <h5>Pilihan Jawaban</h5>
                        <h5 class="text-reguler">
                            <span id="duration-caption">{{count($questions[0]['choices'])}}</span>
                        </h5>
                    </div>
                </div>
                @endif

                @if($type === 'ASSESSMENT')
                    <h3 class="mb-4 mt-7">Daftar Soal</h3>
                    <button class="btn-upload font-15" data-toggle="modal" data-target="#create-pilihan-ganda">
                        <i class="kejar-add"></i>Tambah Soal
                    </button>
                    <!-- Pagination -->
                    @if($questionMeta)
                        <nav class="navigation mt-5">
                            <div>
                                <span class="pagination-detail">{{ $questionMeta['to'] ?? 0 }} dari {{ $questionMeta['total'] }} mapel</span>
                            </div>
                            <ul class="pagination">
                                <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                                    <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
                                </li>
                                @for($i=1; $i <= $questionMeta['last_page']; $i++)
                                <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                                    <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="page-item {{ ((request()->page ?? 1) + 1) > $questionMeta['last_page'] ? 'disabled' : '' }}">
                                    <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
                                </li>
                            </ul>
                        </nav>
                    @endif()

                    <div class="table-questions border-top-none">
                    @foreach($questions as $i => $question)
                        <div class="card type-pilihan-ganda">
                            <div class="w-100 bg-green px-4 py-3">
                                <div class="row justify-content-between px-4">
                                    <div>
                                        <h5>SOAL {{ $i + 1 }}</h5>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" id="nav-{{$i}}" style="cursor: pointer;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="kejar-edit"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-{{$i}}">
                                            <a class="dropdown-item font-15" data-toggle="modal" style="cursor: pointer;" data-target="#update-pilihan-ganda"  data-url="{{ url('/teacher/subject-teacher/assessment/question/' . $question['id'].'/edit/') }}">
                                                Edit Soal
                                            </a>
                                            <a class="dropdown-item font-15" href="javascript:void(0)" style="cursor: pointer;" data-toggle="modal" data-target="#delete_question"
                                                onclick="setDelete('{{$question['id']}}')">
                                                Hapus Soal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="editor-display" id="q_question_{{$i}}">
                                    {!! $question['question'] !!}
                                </div>
                                <textarea hidden>{{$question['question']}}</textarea>
                                <textarea hidden>{{$question['explanation']}}</textarea>
                                <div class="question-answer-group">
                                <table class="question-answer-table">
                                    @foreach($question['choices'] as $key => $choice)
                                    <tr>
                                        <td>
                                            @if($key == $question['answer'])
                                            <i class="kejar-radio-button"></i>
                                            @else
                                            <i class="kejar-belum-dikerjakan"></i>
                                            @endif
                                        </td>
                                        <td class="editor-display">{!! $choice !!}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                </div>
                                <div id="q_answer_{{$i}}" hidden>{!! $question['answer'] !!}</div>
                                <div id="q_choices_{{$i}}" hidden>{{json_encode($question['choices'])}}</div>
                                @if($question['explanation'] !== null && $question['explanation'] !== '' )
                                <div class="explanation-group">
                                    <strong>Pembahasan</strong>
                                    <div class="editor-display">
                                        <div id="q_explanation_{{$i}}">{!! $question['explanation'] !!}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <!-- Pagination -->
                    @if($questionMeta && ($questionMeta['total'] > 10))
                        <nav class="navigation mt-5">
                            <div>
                                <span class="pagination-detail">{{ $questionMeta['to'] ?? 0 }} dari {{ $questionMeta['total'] }} mapel</span>
                            </div>
                            <ul class="pagination">
                                <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                                    <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
                                </li>
                                @for($i=1; $i <= $questionMeta['last_page']; $i++)
                                <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                                    <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                </li>
                                @endfor
                                <li class="page-item {{ ((request()->page ?? 1) + 1) > $questionMeta['last_page'] ? 'disabled' : '' }}">
                                    <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
                                </li>
                            </ul>
                        </nav>
                    @endif()
                @else
                    <h3 class="mb-4 mt-7">Paket</h3>
                    @for($i=0; $i < count($assessments); $i++)
                        <div onclick="viewMA(`{{$assessments[$i]['id']}}`, 'Paket {{$i + 1}}')" class="btn-package">
                            Paket {{$i + 1}}
                        </div>
                    @endfor
                    <button class="btn-upload font-15" data-toggle="modal" data-target="#add-ma">
                        <i class="kejar-add"></i>Tambah Paket
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>
<input type="hidden" id="edit_q_id" />
<input type="hidden" id="selectedChoice" />
<?php $list = ''; ?>
@if($type === 'ASSESSMENT')
        @for($i=0; $i <= count($questions) - 1; $i++)
            <?php $list .= "{$questions[$i]['id']},"; ?>
        @endfor
    @endif
<textarea id="question_list" hidden><?php echo $list; ?></textarea>
@include('teacher.subject_teacher.assessment.mini._upload_pdf')
@if(count($assessments) > 0)
    @include('teacher.subject_teacher.assessment.mini._setting_package')

    <!-- Include Modal Assign -->

    @include('teacher.subject_teacher.assessment.assign._assign_schedule')
    @include('teacher.subject_teacher.assessment.assign._assign_select')
    @include('teacher.subject_teacher.assessment.assign._assign_success')
@endif

@include('teacher.subject_teacher.assessment.mini.answer._validation_answer')
@include('teacher.subject_teacher.assessment.mini.answer._missing_answer')
@include('teacher.subject_teacher.assessment.mini._info_token')
@include('teacher.subject_teacher.assessment.regular.create._pilihan_ganda')
@if(count($assessments) > 0)
    @include('teacher.subject_teacher.assessment.regular.update._pilihan_ganda')
    @include('teacher.subject_teacher.assessment.regular._delete_question')
    @include('teacher.subject_teacher.assessment.regular.update._duration')
@endif
@include('teacher.subject_teacher.assessment.mini.answer._view_answer')

@endsection

@push('script')
<script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
<script src="{{ mix('/js/admin/question/literasi.js') }}"></script>

<script>
    var failedId = '{{$newestPackStatus}}';
    var type = '{{$type}}';
    $(document).ready(() => {
        var params = window.location.search.substr(1);
        if(failedId !== "" && type == 'MINI_ASSESSMENT'){
            viewMA(failedId, "Paket {{$assessmentsMeta['total']}}");
        }
    })

    function setType(val) {
        $('#astype').val(val);
    }

    let validatecCheckQuestion = false;
    let idAssessment = '';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const multiChoices = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'];

    function setAdd(assessmentGroupId, subjectId, grade){
        const url = `{!! URL::to('/teacher/subject-teacher/${assessmentGroupId}/subject/${subjectId}/${grade}/assessment') !!}`;
        $.ajax({
            url,
            type: 'POST',
            data: {
                type: 'ASSESSMENT',
            },
            dataType: 'json',
            beforeSend: function() {
                showLoadingAssesment(4);
            },
            error: function(error) {
                //
            },
            success: function(response) {
                if(response.error === false){
                    location.reload();
                }else{
                    alert('Penyimpanan gagal. Harap ulangi lagi!');
                    $('#LoadingAssess4').hide();
                }
            }
        });
    }

    function changeDurationModal(){
        $('#duration-alert').hide();
        $('#duration').modal('show');
    }

    function saveDuration(assessmentGroupId, subjectId, grade, assessmentId){
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/duration') !!}";
        var duration = $('#duration_assess').val();

        $.ajax({
            url,
            type: 'POST',
            data: {
                assessmentGroupId,
                subjectId,
                grade,
                assessmentId,
                duration,
            },
            dataType: 'json',
            beforeSend: function() {
                $('#setDuration').html('Tunggu...');
                $('#setDuration').prop('disabled', true);
            },
            error: function(error) {
                //
                $('#setDuration').html('Simpan');
                $('#setDuration').prop('disabled', false);
            },
            success: function(data) {
                $('#setDuration').html('Simpan');
                $('#setDuration').prop('disabled', false);
                if (data.status === 200) {
                    $('#duration-caption').html(data.data.duration+' menit');
                    durationVal = data.data.duration;
                    $('#duration').modal('hide');
                }
            }
        });
    }

    function setDelete(id){
        $('#edit_q_id').val(id);
    }

    function editQuestionList(assessmentId){
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/question/delete') !!}";
        var selected = $('#edit_q_id').val();
        var newList = [selected];
        $.ajax({
            url,
            type: 'POST',
            data: {
                assessmentId,
                newList,
            },
            dataType: 'json',
            beforeSend: function() {
                $('#deleteQuestion').html('Tunggu...');
                $('#deleteQuestion').attr('disabled', 'true');
            },
            error: function(error) {
                $('#deleteQuestion').html('Tunggu...');
                $('#deleteQuestion').attr('disabled', 'false');
            },
            success: function(response) {
                if (response.error == false) {
                    location.reload();
                } else{
                    $('#deleteQuestion').html('Tunggu...');
                    $('#deleteQuestion').attr('disabled', 'false');
                    alert('Penghapusan soal gagal. Harap ulangi lagi!');
                }
            }
        });
    }

    function renderChoices(total, tableId){
        var answers = []
        for(var i = 0; i <= total; i++){
            answers += `<tr>\
                            <td>\
                                <div class="radio-group">\
                                    <input type="radio" name='${tableId === "table_add_answer" ? 'cr_answer' : 'ed_answer'}' value=${i}>\
                                    <i class="kejar-belum-dikerjakan"></i>\
                                </div>\
                            </td>\
                            <td>\
                                <div class="ckeditor-group ckeditor-list">\
                                    <textarea name='choices[${i}]' class="ckeditor-field" placeholder="Ketik pilihan jawaban ${i + 1}" ck-type="pilihan-ganda" required></textarea>\
                                    <div class="ckeditor-btn-group ckeditor-btn-1 d-none">\
                                        <button type="button" class="bold-btn" title="Bold (Ctrl + B)">\
                                            <i class="kejar-bold"></i>\
                                        </button>\
                                        <button type="button" class="italic-btn" title="Italic (Ctrl + I)">\
                                            <i class="kejar-italic"></i>\
                                        </button>\
                                        <button type="button" class="underline-btn" title="Underline (Ctrl + U)">\
                                            <i class="kejar-underlined"></i>\
                                        </button>\
                                        <button type="button" class="bullet-list-btn" title="Bulleted list">\
                                            <i class="kejar-bullet"></i>\
                                        </button>\
                                        <button type="button" class="number-list-btn" title="Number list">\
                                            <i class="kejar-number"></i>\
                                        </button>\
                                        <button type="button" class="photo-btn" title="Masukkan foto">\
                                            <i class="kejar-photo"></i>\
                                        </button>\
                                    </div>\
                                </div>\
                            </td>\
                            <td>\
                                <button class="remove-btn" type="button">\
                                    <i class="kejar-close"></i>\
                                </button>\
                            </td>\
                        </tr>`;
        }
        $(`#${tableId}`).html(answers);

    }

    function viewMA(id, title) {

        $('#loading-view').show();
        $('#ma-content-view').hide();
        $('#viewAnswer').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });

        const url = "{!! URL::to('/teacher/subject-teacher/mini-assessment/view') !!}" + "/" + id;
        let data = new Object();

        // data = {};

        var form = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'GET',
            // body: form,
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
            .then(response => response.json())
            .then(function(data) {

                idAssessment = data.detail.id;

                var editFooter = `<div class="row edit-answer justify-content-between align-items-end">\
                <div>\
                <p class="font-15 text-grey-6 ">Diinput oleh ${data.detail.created_by_name}.</p>\
                <p class="font-15 text-grey-6 ">Telah divalidasi oleh ${data.detail.validated_by_name}.</p>\
                </div>\
                <div>\
                <button type="button" onclick="showSave()" class="btn btn-lg btn-skip btn-publish">Edit></button>\
                </div>\
                </div>`;

                var validationFooter = `<div class="row validated-answer justify-content-between align-items-end">\
                <div>\
                <p class="font-15 text-grey-6 ">Diinput oleh ${data.detail.created_by_name}.</p>\
                </div>\
                <div class="row">\
                <button type="button" onclick="showSave()" class="btn btn-lg btn-skip btn-publish mr-4">Edit</button>\
                <button type="button" onclick="showValidation()" class="btn btn-lg btn-publish">Validasi</button>\
                </div>\
                </div>`;

                var createFooter = `<div class="row create-answer justify-content-end align-items-end">\
                <div>\
                <button type="button" id="saveButton" class="btn-save btn btn-lg btn-publish" onClick="checkQuestion('${data.detail.id}')" >Simpan</button>\
                </div>\
                </div>`;

                if (data.detail.validated_by !== null && data.detail.countAnswer === 0) {
                    validatecCheckQuestion = true;
                    $('.footer-view').html(editFooter);

                }

                if (data.detail.validated_by === null && data.detail.countAnswer !== 0) {
                    validatecCheckQuestion = false;
                    $('.footer-view').html(createFooter);

                }

                if (data.detail.validated_by === null && data.detail.countAnswer === 0) {
                    validatecCheckQuestion = true;
                    $('.footer-view').html(validationFooter);

                }

                var naskahHtml = `<div onClick="viewNaskah('${data.detail.pdf}')" class="pts-btn-pdf" role="button">\
                <i class="kejar-pdf"></i>\
                <h4 class="text-reguler ml-4">Lihat Naskah Soal</h4></div>`;

                $('.headGroup').html(`{{ $assessmentGroup }}`);
                $('.title-view').html(title);
                $('.duration-view').html(`${data.detail.duration} Menit`);
                $('#token').html(data.detail.pdf_password);
                $('#ma-id').val(id);
                $('.headSubject-view').html(`{{ $subject['name'] }}`);
                $('#view-naskah').html(naskahHtml);

                $('.tab-1-view').html(data.choicesTab1);
                $('.tab-2-view').html(data.choicesTab2);

                $('#loading-view').hide();
                $('#ma-content-view').show();
                $('.edit-header-view').hide();
                $('.header-view').show();
            })
            .catch(function(error) {
                console.error(error);
            });
    }

    function viewNaskah(pdf) {
        if (typeof window !== undefined) {
            window.open(pdf, '_blank');
        }
    }

    function viewSpinner(questionId, set) {
        if (set === 'success') {
            $(`#pts-choice-load-${questionId}`).hide();
            $(`#pts-choice-success-${questionId}`).show();
            setTimeout(function() {
                $(`#pts-choice-success-${questionId}`).hide();
            }, 2000);
        } else if (set === 'loading') {
            $(`#pts-choice-success-${questionId}`).hide();
            $(`#pts-choice-load-${questionId}`).show();
        }
    }

    async function onClickAnswerPG(number, id, choice, countQ) {
        if (validatecCheckQuestion === true) {
            return false;
        }

        for (let i = 0; i <= countQ; i++) {
            $(`#pts-choice-${id}-${i}`).removeClass('active');
        }

        $(`#pts-choice-${id}-${number}`).addClass('active');
        viewSpinner(id, 'loading');
        setAnswer(choice, id);
    }

    function setAnswer(answer, questionId) {
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/mini/question/update') !!}";

        $.ajax({
            url,
            type: 'POST',
            data: {
                questionId,
                answer,
            },
            dataType: 'json',
            beforeSend: function() {
                //
            },
            error: function(error) {
                //
            },
            success: function(response) {
                if (response.status === 200) {
                    viewSpinner(questionId, 'success');
                    return;
                }
            }
        });
    }

    function checkQuestion(assessmentId) {
        validatecCheckQuestion = true;
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/question/check') !!}" + "/" + assessmentId;
        const htmlSpinner = `Tunggu...`;
        const htmlDone = `SIMPAN`;

        $('#saveButton').html(htmlSpinner);
        $('#saveButton').attr('disabled', 'true');

        var request = new Request(url, {
            method: 'GET',
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
            .then(response => response.json())
            .then(function(data) {
                idAssessment = data.detail.id;

                if (data.detail.validated_by === null && data.detail.countAnswer !== 0) {
                    validatecCheckQuestion = false;
                    $('#viewAnswer').modal('hide');
                    $('#missingAnswer').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true,
                    });
                }

                if (data.detail.validated_by === null && data.detail.countAnswer === 0) {
                    validatecCheckQuestion = true;
                    $('.edit-header-view').hide();
                    $('.header-view').show();
                    var validationFooter = `<div class="row validated-answer justify-content-between align-items-end">\
                    <div>\
                    <p class="font-15 text-grey-6 ">Diinput oleh ${data.detail.created_by_name}.</p>\
                    </div>\
                    <div class="row">\
                    <button type="button" onclick="showSave()" class="btn btn-lg btn-skip btn-publish mr-4">Edit</button>\
                    <button type="button" onclick="showValidation()" class="btn btn-lg btn-publish">Validasi</button>\
                    </div>\
                    </div>`;

                    $('.footer-view').html(validationFooter);
                    if(idAssessment === failedId){
                        $('#answer_status').remove();
                    }
                }

                if (data.detail.validated_by !== null && data.detail.countAnswer === 0) {
                    validatecCheckQuestion = true;
                    $('.edit-header-view').hide();
                    $('.header-view').show();
                    var editFooter = `<div class="row edit-answer justify-content-between align-items-end">\
                    <div>\
                    <p class="font-15 text-grey-6 ">Diinput oleh ${data.detail.created_by_name}.</p>\
                    <p class="font-15 text-grey-6 ">Telah divalidasi oleh ${data.detail.validated_by_name}.</p>\
                    </div>\
                    <div>\
                    <button type="button" onclick="showSave()" class="btn btn-lg btn-skip btn-publish">Edit</button>\
                    </div>\
                    </div>`;
                    $('.footer-view').html(editFooter);
                    if(idAssessment === failedId){
                        $('#answer_status').remove();
                    }
                }

                $('#saveButton').html(htmlDone);
                $('#saveButton').removeAttr('disabled');
            })
            .catch(function(error) {
                console.error(error);
                validatecCheckQuestion = false;
            });
    }

    function closeMissAnswer() {
        $('#missingAnswer').modal('hide');
        $('#viewAnswer').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    }

    function showValidation() {
        $('#validationAnswer').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
        $('#viewAnswer').modal('hide');
    }

    function closeValidation() {
        $('#validationAnswer').modal('hide');
        $('#viewAnswer').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    }

    function validationAssessment() {
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/question/validation') !!}";

        $('#validasiButton').html('Tunggu...');
        $('#validasiButton').attr('disabled', 'true');

        $.ajax({
            url,
            type: 'POST',
            data: {
                idAssessment
            },
            dataType: 'json',
            beforeSend: function() {
                //
            },
            error: function(error) {
                //
            },
            success: function(data) {
                $('#validasiButton').html('Validasi');
                $('#validasiButton').removeAttr('disabled');

                $('#validationAnswer').modal('hide');
                $('#viewAnswer').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true,
                });

                validatecCheckQuestion = true;

                var editFooter = `<div class="row edit-answer justify-content-between align-items-end">\
                <div>\
                <p class="font-15 text-grey-6 ">Diinput oleh ${data.detail.created_by_name}.</p>\
                <p class="font-15 text-grey-6 ">Telah divalidasi oleh ${data.detail.validated_by_name}.</p>\
                </div>\
                <div>\
                <button type="button" onclick="showSave()" class="btn btn-lg btn-skip btn-publish">Edit</button>\
                </div>\
                </div>`;

                $('.footer-view').html(editFooter);

            }
        });
    }


    function showSave() {
        validatecCheckQuestion = false;
        $('.edit-header-view').show();
        $('.header-view').hide();

        var createFooter = `<div class="row create-answer justify-content-end align-items-end">\
        <div>\
        <button type="button" id="saveButton" class="btn-save btn btn-lg btn-publish" onClick="checkQuestion('${idAssessment}')" >Simpan</button>\
        </div>\
        </div>`;

        $('.footer-view').html(createFooter);
    }

    function showLoadingAssesment(index) {
        $(`#LoadingAssess${index}`).show();
    }

    function showLoadingCreate() {
        // TO DO: add set type for ASSESSMENT
        setType('MINI_ASSESSMENT');
        $("#LoadingCreate").show();
        $("#saveBtn").prop('disabled', true);
        $("#saveForm").submit();
    }

    $('#upload_pdf_file').on('change', (e) => {
        if (e.currentTarget.files[0].size <= 1000000) {
            $('#upload_pdf_name').val(e.currentTarget.files[0].name);
            if ($('#file_alert').hasClass('show')) {
                $('#file_alert').removeClass('show').addClass('hide');
            }
        } else {
            $('#file_alert').removeClass('hide').addClass('show');
            setInterval(() => {
                $('#file_alert').removeClass('show').addClass('hide')
            }, 4000)
        }
    })
</script>
@endpush
