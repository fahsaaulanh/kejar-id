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
                <button class="btn-upload mb-0" data-toggle="modal" data-target="#create-pilihan-ganda" onclick="setAdd()">
                    <i class="kejar-add"></i>Input Soal
                </button>
            </div>
        </div>
    @else
        <button class="btn btn-primary font-15" onclick="modalAssignShow(1)">
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
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
            <div class="tab-pane fade show active" id="packgae" role="tabpanel" aria-labelledby="packgae-tab">
                <div class="row mt-8">
                    @if($dualType === true)
                        <div class="alert alert-info" role="alert">
                            Assessment ini memiliki dua tipe!
                            @if($type === 'ASSESSMENT')
                            <a href="{{ URL('teacher/subject-teacher/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment/mini_assessment') }}">Lihat tipe Mini Assessment</a>.
                            @else
                            <a href="{{ URL('teacher/subject-teacher/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment/assessment') }}">Lihat tipe Assessment</a>.
                            @endif
                        </div>
                    @endif
                    <div class="col">
                        <h3>Pengaturan</h3>
                    </div>
                    <div class="col col-sm-2">
                        @if($type === 'ASSESSMENT')
                        <button class="btn bg-white btn-revise" data-toggle="modal" data-target="#duration"><i class="kejar-setting"></i>Ubah</button>
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
                        <h5 class="text-reguler">{{($assessments[0]['duration'] == null ? '-' : $assessments[0]['duration'].' menit')}}</h5>
                    </div>
                </div>

                @if($type === 'ASSESSMENT')
                    <h3 class="mb-4">Daftar Soal</h3>
                    <button class="btn-upload font-15" data-toggle="modal" data-target="#create-pilihan-ganda" onclick="setAdd()">
                        <i class="kejar-add"></i>Tambah Soal
                    </button>
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

                    @for($i=0; $i <= count($questions) - 1; $i++)
                        <div class="pb-4">
                            <div class="w-100 bg-green px-4 py-3">
                                <div class="row justify-content-between px-4">
                                    <h5>SOAL {{ $i + 1 }}</h5>
                                    <div class="justify-content-end">
                                        <a href="#" id="nav-{{$i}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="kejar-add"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-{{$i}}">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-pilihan-ganda"
                                                onclick="setEditData({{$i}}, '{{$questions[$i]['id']}}')">
                                                <i class="kejar-edit"></i> Edit Soal
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_question"
                                                onclick="setDelete('{{$questions[$i]['id']}}')">
                                                <i class="kejar-add"></i> Hapus Soal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 border-grey-13 px-4 py-3">
                                <div class="pb-8">
                                    {{$questions[$i]['question']}}
                                </div>
                                <textarea id="q_question_{{$i}}" hidden>{{$questions[$i]['question']}}</textarea>
                                <textarea id="q_explanation_{{$i}}" hidden>{{$questions[$i]['explanation']}}</textarea>
                                <div class="pb-8">
                                    @foreach($questions[$i]['choices'] as $key => $ch)
                                        <div class="radio-group">
                                            @if($key === $questions[$i]['answer'])
                                                <i class="kejar-radio-button"></i>
                                            @else
                                                <i class="kejar-belum-dikerjakan"></i>
                                            @endif
                                            {{$questions[$i]['choices'][$key]}}
                                        </div>
                                    @endforeach
                                </div>
                                <div id="q_answer_{{$i}}" hidden>{{$questions[$i]['answer']}}</div>
                                <div id="q_choices_{{$i}}" hidden>{{json_encode($questions[$i]['choices'])}}</div>
                                <h5 class="pb-4">Pembahasan:</h5>
                                <div>{{$questions[$i]['explanation']}}</div>
                            </div>
                        </div>
                    @endfor

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
                    <h3 class="mb-4">Paket</h3>
                    @for($i=0; $i < count($assessments); $i++)
                        <div onclick="viewMA(`{{$assessments[$i]['id']}}`, 'Paket {{$i + 1}}')" class="w-100 bg-grey-15 mb-4 px-4 py-3">
                            <a class="text-black-1">Paket {{$i + 1}}</a>
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
<script>
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

    const multiChoices = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

    function saveQuestion(assessmentGroupId, subjectId, grade, assessmentId){
        const url = `{!! URL::to('/teacher/subject-teacher/${assessmentGroupId}/subject/${subjectId}/${grade}/assessment') !!}`;
        // const url = "{!! URL::to('/teacher/subject-teacher/assessment/question/create') !!}";

        var choicesElement = document.getElementsByName("cr_choices");
        var choicesRadio = document.getElementsByName("cr_answer");
        var choices = {};
        var trueAnswer = "";
        for(var i = 0; i <= choicesElement.length - 1; i++){
            choices[multiChoices[i]] = choicesElement[i].value;
            if(choicesRadio[i].checked === true){
                trueAnswer = multiChoices[i];
            }
        }
        var question = $('#question').val();
        var explanation = $('#explanation').val();
        $.ajax({
            url,
            type: 'POST',
            data: {
                assessmentGroupId,
                type: 'ASSESSMENT',
                subjectId,
                grade,
                assessmentId,
                question,
                choices,
                trueAnswer,
                explanation,
            },
            dataType: 'json',
            beforeSend: function() {
                showLoadingAssesment(1);
            },
            error: function(error) {
                //
            },
            success: function(response) {
                var statusError = Object.keys(response).map(item => response[item].error !== false);
                if(statusError > 0){
                    console.log(statusError)
                }else{
                    window.location.reload();
                }
            }
        });
    }

    async function setAdd(){
        document.getElementById('addplus').style.visibility = 'initial';
        await renderChoices(3, 'table_add_answer');
    }

    async function setEditData(index, id){
        var choicesElement = document.getElementsByName("ed_choices");
        var choicesRadio = document.getElementsByName("ed_answer");
        $('#question2').html($(`#q_question_${index}`).html());
        $('#explanation2').html($(`#q_explanation_${index}`).html());
        var choices = $(`#q_choices_${index}`).html();
        var answer = $(`#q_answer_${index}`).html();
        var listChoices = JSON.parse(choices);
        await renderChoices(Object.keys(listChoices).length - 1, 'table_edit_answer');
        await Object.keys(listChoices).map((key, index) => {
            choicesElement[index].innerHTML = listChoices[key];
            choicesElement[index].value = listChoices[key];
        })
        var answerIndex = multiChoices.indexOf(answer);
        choicesRadio[answerIndex].checked = true;
        $('#selectedChoice').val(answerIndex);
        $('#edit_q_id').val(id);
        document.getElementById('editplus').style.visibility = 'initial';
    }

    function editQuestion(subjectId, grade){
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/question/update') !!}";

        var choicesElement = document.getElementsByName("ed_choices");
        var choicesRadio = document.getElementsByName("ed_answer");

        var choices = {};
        var trueAnswer = "";
        for(var i = 0; i <= choicesElement.length - 1; i++){
            choices[multiChoices[i]] = choicesElement[i].value;
            if(choicesRadio[i].checked === true){
                trueAnswer = multiChoices[i];
            }
        }
        var question = $('#question2').val();
        var explanation = $('#explanation2').val();
        var questionId = $('#edit_q_id').val();
        $.ajax({
            url,
            type: 'POST',
            data: {
                questionId,
                subjectId,
                grade,
                question,
                choices,
                trueAnswer,
                explanation,
            },
            dataType: 'json',
            beforeSend: function() {
                showLoadingAssesment(2);
            },
            error: function(error) {
                //
            },
            success: function(response) {
                if (response.status === 200) {
                    window.location.reload();
                    return;
                }
            }
        });
    }

    function addChoice(event, tableId){
        var choicesElement = document.getElementsByName(`${tableId === "table_add_answer" ? 'cr_answer' : 'ed_answer'}`);
        var answers = `<tr>\
                            <td>\
                                <div class="radio-group">\
                                    <input type="radio" name='${tableId === "table_add_answer" ? 'cr_answer' : 'ed_answer'}' value=${choicesElement.length}>\
                                    <i class="kejar-belum-dikerjakan"></i>\
                                </div>\
                            </td>\
                            <td>\
                                <div class="ckeditor-group ckeditor-list">\
                                    <textarea onchange="insertInto(event)" name='${tableId === "table_add_answer" ? 'cr_choices' : 'ed_choices'}' class="ckeditor-field" placeholder="Ketik pilihan jawaban ${choicesElement.length + 1}" ck-type="pilihan-ganda" required></textarea>\
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
                                <button class="remove-btn" type="button" onclick="removeChoice(event, '${tableId === "table_add_answer" ? 'addplus' : 'editplus'}')">\
                                    <i class="kejar-close"></i>\
                                </button>\
                            </td>\
                        </tr>`;
        var ind = parseInt($('#selectedChoice').val());
        var set = $(`#${tableId}`).html() + answers;
        var total = choicesElement.length + 1
        document.getElementById(tableId).innerHTML += answers;
        if(tableId === "table_edit_answer"){
            choicesElement[ind].checked = true;
        }
        if(total == 5){
            event.currentTarget.style.visibility = 'hidden';
        }
    }

    function removeChoice(event, plusBtnId){
        event.currentTarget.parentElement.parentElement.remove();
        var choicesElement = document.getElementsByName("ed_choices");
        var total = choicesElement.length - 1;
        if(total < 5){
            document.getElementById(plusBtnId).style.visibility = 'initial';
        }

    }

    function insertInto(event){
        event.currentTarget.innerHTML = event.currentTarget.value;
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
                showLoadingAssesment(0);
            },
            error: function(error) {
                //
            },
            success: function(response) {
                if (response.status === 200) {
                    window.location.reload();
                    return;
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
        var list = $('#question_list').val();
        var newList = list.split(',').filter(item => item !== selected && item !== '');

        $.ajax({
            url,
            type: 'POST',
            data: {
                assessmentId,
                newList,
            },
            dataType: 'json',
            beforeSend: function() {
                showLoadingAssesment(3);
            },
            error: function(error) {
                //
            },
            success: function(response) {
                if (response.status === 200) {
                    window.location.reload();
                    return;
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
                                    <textarea onchange="insertInto(event)" name='${tableId === "table_add_answer" ? 'cr_choices' : 'ed_choices'}' class="ckeditor-field" placeholder="Ketik pilihan jawaban ${i + 1}" ck-type="pilihan-ganda" required></textarea>\
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
                                <button class="remove-btn" type="button" onclick="removeChoice(event, '${tableId === "table_add_answer" ? 'addplus' : 'editplus'}')">\
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
                <button type="button" onclick="showSave()" class="btn btn-lg btn-primary">EDIT</button>\
                </div>\
                </div>`;

                var validationFooter = `<div class="row validated-answer justify-content-between align-items-end">\
                <div>\
                <p class="font-15 text-grey-6 ">Diinput oleh ${data.detail.created_by_name}.</p>\
                </div>\
                <div>\
                <button type="button" onclick="showSave()" class="btn btn-lg btn-link">EDIT</button>\
                <button type="button" onclick="showValidation()" class="btn btn-lg btn-primary">VALIDASI</button>\
                </div>\
                </div>`;

                var createFooter = `<div class="row create-answer justify-content-end align-items-end">\
                <div>\
                <button type="button" id="saveButton" class="btn-save btn btn-lg btn-primary" onClick="checkQuestion('${data.detail.id}')" >SIMPAN</button>\
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
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/question/update') !!}";

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
                    <div>\
                    <button type="button" onclick="showSave()" class="btn btn-lg btn-link">EDIT</button>\
                    <button type="button" onclick="showValidation()" class="btn btn-lg btn-primary">VALIDASI</button>\
                    </div>\
                    </div>`;

                    $('.footer-view').html(validationFooter);
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
                    <button type="button" onclick="showSave()" class="btn btn-lg btn-primary">EDIT</button>\
                    </div>\
                    </div>`;
                    $('.footer-view').html(editFooter);
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
                <button type="button" onclick="showSave()" class="btn btn-lg btn-primary">EDIT</button>\
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
        <button type="button" id="saveButton" class="btn-save btn btn-lg btn-primary" onClick="checkQuestion('${idAssessment}')" >SIMPAN</button>\
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
