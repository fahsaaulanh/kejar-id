@extends('layout.index')

@section('title', $assessmentGroup)

@section('content')
    <div class="container-lg">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/supervisor/'.$assessmentGroupValue.'/subject/'.$subject['id'].'/'.$grade) }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/supervisor/'.$assessmentGroupValue.'/subject') }}">{{$assessmentGroup}}</a>
            <span class="breadcrumb-item active">{{$subject['name']}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{ $StudentGroupDetail['name'] }}</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                @if($reportType == 'MINI_ASSESMENT')
                    <h5>Token/Password PDF</h5>
                    {{ $token }}
                @endif
            </div>
            <div class="col-md-6 text-right">
                <button onclick="dataIndex()" class="btn btn-publish float-right mr-3"> Refresh Data</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="table-responsive table-result-stage">
                    <table class="table table-bordered" id="table-kejar">
                        <tr class="table-head">
                            <th width="1%">No.</th>
                            <th width="30%">Nama</th>
                            @if($reportType == 'ASSESMENT')
                                <th>Token</th>
                            @endif
                            <th width="11%">Hadir</th>
                            <th>Status</th>
                            <th width="25%">Catatan Siswa</th>
                            <th width="25%">Catatan Pengawas</th>
                        </tr>
                        <tbody id="studentData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-md" id="view-note">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catatan Pengawas</h5>
                    <button class="close modal-close" data-dismiss="modal">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="noteContent" style="display:none">
                        <div class="row">
                            <div class="col-12">
                                <h5 id="note-name"></h5>
                                <input type="hidden" id="note-id">
                                <input type="hidden" id="note-name-val">
                                <input type="hidden" id="note-nis-val">
                                <input type="hidden" id="student_note-val">
                                <input type="hidden" id="teacher_note-val">
                                <p class="mt-3"><span id="note-nis"></span>, {{ $StudentGroupDetail['name'] }}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <h5>Catatan Siswa</h5>
                                <p class="mt-3" id="note-student"></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <h5>Catatan Pengawas</h5>
                                <div id="note-teacher">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <div class="text-right col-md-12 p-0" id="btn-update" style="display:none">
                        <button class="btn btn-cancel pull-right" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary pull-right" onclick="updateNote()">Simpan</button>
                    </div>
                    <div class="text-right col-md-12 p-0" id="btn-edit" style="display:none">
                        <button class="btn btn-primary pull-right" onclick="editNote()">Edit</button>
                    </div>
                    <div id="noteLoading" class="col-12 text-center mt-4" style="display:none">
                        <div class="row justify-content-center">
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Memperbarui data...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Memperbarui data...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Memperbarui data...</span>
                            </div>
                        </div>
                        <div class="mt-2 row justify-content-center">
                            <h5>Memperbarui data...</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-md" id="no-schedule-modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Belum Ditugaskan</h5>
                    <button class="close modal-close" data-dismiss="modal">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="no-schedule-modal-content"></div>
                </div>
                <div class="modal-footer text-right">
                    <div class="text-right col-md-12 p-0">
                        <button class="btn btn-primary pull-right" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-md" id="change-presence-modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Kehadiran</h5>
                    <button class="close modal-close" data-dismiss="modal">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="change-presence-modal-content"></div>
                </div>
                <div class="modal-footer text-right">
                    <div class="text-right col-md-12 p-0" id="change-presence-btn">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script>

    var studentData = [];
    var reportType = "{{ $reportType }}";
    function dataIndex() {
        var colspan = 6;
        if (reportType == 'ASSESMENT') {
            colspan = 7;
        }
        $("#studentData").html('<tr>\
                                <td colspan="'+colspan+'" class="text-center">\
                                    <div class="spinner-border" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                    Sedang mengambil data...\
                                </td>\
                            </tr>\
                            ');

        const url = "{!! URL::to('/teacher/supervisor/' . $assessmentGroupValue . '/get-student-groups') !!}";
        let data  = new Object();
        var student_group_id = "{{$id}}";

        var colspan = 4;
        if (reportType == 'ASSESMENT') {
            colspan = 5;
        }
        data = {
            student_group_id,
            colspan
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
            $('#studentData').html(data.html);
            studentData = data.data;
            getAttendance();
        })
        .catch(function(error) {
            console.error(error);
        });
    }

    async function getAttendanceStudent(student_id, student_name) {
        var school_id = "{{ $school_id }}";
        var assessment_group_id = "{{ $assessmentGroupValue }}";
        var subject_id = "{{$subject['id']}}";

        const url = "{!! URL::to('/teacher/supervisor/' . $assessmentGroupValue . '/student-attendance') !!}";

        request = {
            student_id,
            subject_id,
            school_id,
            assessment_group_id,
            reportType,
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        await $.ajax({
            method: 'post',
            data: request,
            url: url,
            success: function (response) {
                if(response.status == 200){
                    $("#student-data-loading-"+student_id).hide();
                    $("#student-data-"+student_id).after(response.html);
                }else{
                    student_name = "'"+student_name+"'";
                    $("#student-data-loading-"+student_id).html('<span style="cursor:pointer" onclick="noScheduleModal('+student_name+')">Belum ditugaskan</span>');
                }
            },
            error: function (error) {
                $("#student-data-loading-"+studentId)
                .html('<span class="btn btn-primary"\
                        onclick="getScore()">\
                        Coba Kembali dapatkan nilai\
                       </span>');
            }
        });
    }

    function noScheduleModal(student_name){
        var text = 'Siswa <b>'+student_name+'</b> belum direkomendasikan\
                    untuk mengikuti penilaian ini. Hubungi guru mapel untuk\
                    memintakan penugasan/rekomendasi.';
        $('#no-schedule-modal-content').html(text);
        $('#no-schedule-modal').modal('show');
    }

    async function getAttendance() {
        const promisesSave = studentData.map((d) => getAttendanceStudent(d.id, d.name));
        await Promise.all(promisesSave);
    }

    dataIndex();

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

        $("#note-student").html('<span class="text-grey">Siswa belum/tidak membuat catatan.<span>');
        $("#student_note-val").val("");
        if (noteStudent) {
            if (noteStudent != '-') {
                $("#note-student").html(noteStudent);
                $("#student_note-val").val(noteStudent);
            }
        }

        $("#note-nis").html(nis);
        $("#note-nis-val").val(nis);

        $("#note-id").val(id);

        $("#note-name").html(name);
        $("#note-name-val").val(name);

        $("#noteContent").show();
    }

    function changePresence(schedule_id, presence, confirmation = false, student_name = ''){

        $('#change-presence-modal').modal('hide');
        if(confirmation){
            $('#change-presence-modal-content').html('Hapus kembali kehadiran siswa <b>'+student_name+' </b>?');
            var param = "'"+schedule_id+"',"+presence+",0,'"+student_name+"'";
            var button = '<button class="btn btn-link pull-right text-danger" data-dismiss="modal">Batal</button>';
            button += '<button class="btn btn-danger pull-right" onclick="changePresence('+param+')">Hapus</button>';
            $('#change-presence-btn').html(button);
            $('#change-presence-modal').modal('show');
            return;
        }

        if (presence) {
            presenceText = 'Tandai';
        }else{
            presenceText = 'Hadir';
        }

        var html = presenceText+' <span class="spinner-border">\
                        <span class="sr-only">Loading...</span>\
                    </span>';

        $('#presenceBtn-'+schedule_id).html(html);

        const url = "{!! URL::to('/teacher/supervisor/' . $assessmentGroupValue . '/student-attendance/update') !!}";
        let data  = new Object();
        data = {
            schedule_id,
            presence
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
            var presenceText = 'Tandai';
            var presenceConfrim = 0;

            if (data.status == 200) {
                if (presence) {
                    presence = 0;
                    presenceText = 'Hadir';
                    presenceConfrim = 1;
                }else{
                    presence = true;
                }
            }else{
                if (presence) {
                    presence = true;
                }else{
                    presence = 0;
                    presenceText = 'Hadir';
                    presenceConfrim = 1;
                }
            }

            var presenceParams = "'"+schedule_id+"',"+presence+","+presenceConfrim+",'"+student_name+"'";

            var html = '<span class="btn btn-link btn-lg\
        text-decoration-none" onclick="changePresence('+presenceParams+')">'+presenceText+'</span>';

            $('#presenceBtn-'+schedule_id).html(html+' <i class="kejar-checklist font-15"></i>');

            setTimeout(function() {
                $('#presenceBtn-'+schedule_id).html(html);
            }, 2000);

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
        if(!student_note){
            student_note = '-';
        }
        var schedule_id = $("#note-id").val();

        // run save

        const url = "{!! URL::to('/teacher/supervisor/' . $assessmentGroupValue . '/student-attendance/update') !!}";
        let data  = new Object();

        data = {
            schedule_id,
            teacher_note: teacher_note,
            student_note: student_note,
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
            changeNoteValue(schedule_id, student_note ,teacher_note, nis, name);
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
