@extends('layout.index')

@section('title', $miniAssessmentGroup)

@section('content')
    <div class="container-lg">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/subject-teachers/mini-assessment/'.$miniAssessmentGroupValue.'/subject/'.$subject['id'].'/'.$grade) }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/subject-teachers/mini-assessment/'.$miniAssessmentGroupValue) }}">{{$miniAssessmentGroup}}</a>
            <span class="breadcrumb-item active">{{$subject['name']}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{ $StudentGroupDetail['name'] }}</h2>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <form method="post" action="{{ URL('teacher/subject-teachers/mini-assessment/'.$miniAssessmentGroupValue.'/subject/'.$subject['id'].'/'.$grade.'/batch/'.$batchId.'/score/'.$StudentGroupDetail['id'].'/export') }}">
                    @csrf
                    <button type="submit" class="btn btn-revise float-right"><i class="kejar-download text-blue mr-2"></i> Unduh Rincian</button>
                </form>
                <button onclick="scoreIndex()" class="btn btn-publish float-right mr-3"> Refresh Data</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="table-responsive table-result-stage">
                    <table class="table table-bordered" id="table-kejar">
                        <tr class="table-head">
                            <th width="1%">No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Hadir</th>
                            <th width="30%">Catatan</th>
                            <th>Durasi<br>(menit)</th>
                            <th>NR</th>
                            <th>NA</th>
                        </tr>
                        <tbody id="scoreData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p>Keterangan :</p>
                <p>
                    <strong>NR</strong> = Nilai Rekomendasi
                </p>
                <p>
                    <strong>NA</strong> = Nilai Akhir
                </p>
            </div>
        </div>
    </div>
@include('teacher.mini_assessments.subjects.subject_teachers.study_group_report._note')
@endsection

@push('script')

<script type="text/javascript">
    function handleChange(input) {
        if (input.value < 0) input.value = 0;
        if (input.value > 100) input.value = 100;
    }

    function scoreIndex(page = 1){
        $("#scoreDataLoading").show();
        $("#scoreData").html('<tr>\
                                <td colspan="8" class="text-center">\
                                    <div class="spinner-border" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                    Sedang mengambil data...\
                                </td>\
                            </tr>\
                            ');
        var miniAssessmentGroupValue = "{!! $miniAssessmentGroupValue !!}";
        var subjectId = "{!! $subjectId !!}";
        var grade = "{!! $grade !!}";
        var batchId = "{!! $batchId !!}";
        var StudentGroupId = "{{ $StudentGroupDetail['id'] }}";

        const url = "{!! URL::to('/teacher/mini-assessment/score-by-student-group') !!}";
        let data  = new Object();

        data = {
            miniAssessmentGroupValue: miniAssessmentGroupValue,
            subjectId: subjectId,
            batchId: batchId,
            grade: grade,
            page: page,
            student_group_id: StudentGroupId,
            paginationFunction: "scoreIndex"
        };

        var form    = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'POST',
            body: form,
            headers: new Headers({
            'Content-Type' : 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
        .then(response => response.json())
        .then(function(data) {
            $('#scoreData').html(data);
            $("#scoreDataLoading").hide();
        })
        .catch(function(error) {
            console.error(error);
            $("#scoreDataLoading").hide();
        });
    }
    scoreIndex();

    function modeEdit(id) {
        $("#score-td-"+id).removeClass("column-white").addClass("column-grey");
        $("#score-input-"+id).removeClass("input-score-white").addClass("input-score-grey");
        $("#score-alert-"+id).empty();
    }

    function updateScore(id) {
        $("#score-td-"+id).removeClass("column-grey").addClass("column-white");
        $("#score-input-"+id).removeClass("input-score-grey").addClass("input-score-white");

        $("#score-alert-"+id).html('<div class="spinner-border" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                     </div>');

        // run save

        const url = "{!! URL::to('/teacher/mini-assessment/update-score') !!}";
        let data  = new Object();

        data = {
            id: id,
            score: $("#score-input-"+id).val(),
        };

        var form    = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'POST',
            body: form,
            headers: new Headers({
            'Content-Type' : 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
        .then(response => response.json())
        .then(function(data) {
            $("#score-alert-"+id).html('<i class="kejar-sudah-dikerjakan text-green-2"></i>');

            setTimeout(function() {
                $("#score-alert-"+id).empty();
            }, 2000);
        })
        .catch(function(error) {
            console.error(error);
        });
    }

    function changePresence(id, presence, value) {

        // run save

        $("#presenceBtn-"+id).html('<div class="spinner-border mr-1" role="status">\
                                            <span class="sr-only">Loading...</span>\
                                         </div>Proses\
                                        ');

        const url = "{!! URL::to('/teacher/mini-assessment/update-presence') !!}";
        let data  = new Object();

        data = {
            id: id,
            presence: presence,
            value: value,
            subject_id: "{{$subject['id']}}",
            mini_assessment_group_id: "{{$miniAssessmentGroupId}}",
        };

        var form    = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'POST',
            body: form,
            headers: new Headers({
            'Content-Type' : 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
        .then(response => response.json())
        .then(function(data) {
            $("#presenceBtn-"+data.id).html(data.btn);
        })
        .catch(function(error) {
            console.error(error);
        });
    }

    function changeNote(id, noteStudent, noteTeacher, nis, name) {
        $("#noteContent").hide();

        $("#view-note").modal('show');

        var info = '<p class="text-muted">';
                info += '<small>Catatan pengawas merupakan bagian dari berita acara kegiatan.</small>';
            info += '</p>';
        $("#note-teacher").html(info+'<textarea rows="6" id="teacher_note" \
         class="form-control" placeholder="Ketik catatan..."></textarea>');

        $("#teacher_note-val").val("");
        if (noteTeacher) {
            $("#note-teacher").html(noteTeacher);
            $("#teacher_note-val").val(noteTeacher);
            $("#btn-update").hide();
            $("#btn-edit").show();
        }else{
            $("#btn-update").show();
            $("#btn-edit").hide();
        }

        $("#note-student").html('<span class="text-muted">Siswa belum/tidak membuat catatan.<span>');
        $("#student_note-val").val("");
        if (noteStudent) {
            $("#note-student").html(noteStudent);
            $("#student_note-val").val(noteStudent);
        }

        $("#note-nis").html(nis);
        $("#note-nis-val").val(nis);

        $("#note-id").val(id);

        $("#note-name").html(name);
        $("#note-name-val").val(name);

        $("#noteContent").show();
    }

    function updateNote() {
        $("#noteLoading").show();
        var teacher_note = $("#teacher_note").val();
        var student_note = $("#student_note-val").val();
        var id = $("#note-id").val();

        // run save

        const url = "{!! URL::to('/teacher/mini-assessment/update-note') !!}";
        let data  = new Object();

        data = {
            id: id,
            teacher_note: teacher_note,
        };

        var form    = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'POST',
            body: form,
            headers: new Headers({
            'Content-Type' : 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
        .then(response => response.json())
        .then(function(data) {
            var nis = $("#note-nis-val").val();
            var name = $("#note-name-val").val();
            changeNoteValue(id, student_note ,teacher_note, nis, name);
            $("#noteLoading").hide();
        })
        .catch(function(error) {
            console.error(error);
        });
    }

    function changeNoteValue(id, student_note ,teacher_note, nis, name) {

        var note = "'"+id+"','"+student_note+"','"+teacher_note+"','"+nis+"','"+name+"'";

        var html = "";
        if(teacher_note){
            html += '<span style="cursor: pointer;" class="text-dark" onclick="changeNote('+note+')">';
                html += teacher_note;
            html += '</span>';
        }else{
            html += '<span style="cursor: pointer;" class="text-muted" onclick="changeNote('+note+')">';
                html += "Belum ada catatan"
            html += '</span>';
        }

        $("#note-data-"+id).html(html);
        $("#view-note").modal('hide');
    }

    function editNote() {
        var teacher_note = $("#teacher_note-val").val();
        var info = '<p class="text-muted">';
                info += '<small>Catatan pengawas merupakan bagian dari berita acara kegiatan.</small>';
            info += '</p>';
        $("#note-teacher").html(info+'<textarea rows="6" id="teacher_note" class="form-control" \
                                    placeholder="Ketik catatan...">'+teacher_note+'</textarea>');

        $("#btn-update").show();
        $("#btn-edit").hide();
    }

</script>
@endpush
