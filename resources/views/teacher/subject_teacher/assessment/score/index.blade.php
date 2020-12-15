@extends('layout.index')

@section('title', 'Nilai dan Penugasan')

@section('content')
<div class="container-lg">

    <!-- Link Back -->
    <a class="btn-back" href="{{ url('/teacher/'.$teacherType.'/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment') }}">
        <i class="kejar-back"></i>Kembali
    </a>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('/teacher/'.$teacherType.'/'.$assessmentGroupId.'/subject') }}">{{$assessmentGroup}}</a>
        <span class="breadcrumb-item active">{{$subject['name']}}</span>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">{{$studentGroup['name']}}</h2>
    </div>
    <div class="row justify-content-between align-items-end">
        <div class="col-6">
            <p>Keterangan :</p>
            <div>
                <strong>B</strong> = Benar;
                <span>
                    <strong>S</strong> = Salah;
                </span>
                <span>
                    <strong>K</strong> = Kosong;
                </span>
            </div>
            <div>
                <strong>NR</strong> = Nilai Rekomendasi;
                <span>
                    <strong>NA</strong> = Nilai Akhir
                </span>
            </div>
        </div>
        <div class="col-6">
            <div class="row justify-content-end">
                <div class="pr-4">
                    <button onclick="scoreIndex()" class="btn btn-publish"><i class="kejar-refresh mr-2"></i> Refresh Data</button>
                </div>
                <!-- <form method="post">
                    @csrf
                    <button type="submit" class="btn btn-revise"><i class="kejar-download text-blue mr-2"></i> Unduh Rincian</button>
                </form> -->
            </div>

        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="table-responsive table-result-stage">
                <table class="table table-bordered" id="table-kejar">
                    <tr class="table-head">
                        <th rowspan="2" class="align-middle" width="1%">No</th>
                        <th rowspan="2" class="align-middle">Nama Siswa</th>
                        <th rowspan="2" class="align-middle">NIS</th>
                        <th rowspan="2" class="align-middle">Durasi <br>(menit)</th>
                        <th colspan="3">Jawaban</th>
                        <th rowspan="2" class="align-middle">NR</th>
                        <th rowspan="2" class="align-middle">NA</th>
                    </tr>
                    <tr class="table-head">
                        <th>B</th>
                        <th>S</th>
                        <th>K</th>
                    </tr>
                    <tbody id="scoreData">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('teacher.subject_teacher.assessment.score._setting_schedule')
@include('teacher.subject_teacher.assessment.score._delete_schedule')
@include('teacher.subject_teacher.assessment.score._about_token')

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/clockpicker/jquery-clockpicker.min.css')}}">
@endsection

@push('script')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('assets/plugins/clockpicker/jquery-clockpicker.min.js')}}"></script>
<script type="text/javascript">
    moment.locale('id');

    $(".datepicker").datepicker({
        format: 'dd/mm/yyyy'
    });

    $('.clockpicker').clockpicker({
        placement: 'top',
        align: 'right',
        autoclose: true,
        'default': 'now'
    });
    let studentId = ""
    let studentName = ""
    let scheduleId = ""


    var typeAssesment = "{{ $type }}";
    var assesment = [];

    if (typeAssesment == "MINI_ASSESSMENT") {

        var assesmentDatas = @json($assessments);
        $.each(assesmentDatas, function(key, value) {
            assesment.push(value.id);
        });
    } else {

        var assesmentDatas = @json($assessments);
        assesment = assesmentDatas[0].id;
    }

    function handleChange(input) {
        if (input.value < 0) input.value = 0;
        if (input.value > 100) input.value = 100;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function scoreIndex(page = 1) {
        $("#scoreDataLoading").show();
        $("#scoreData").html('<tr>\
                                <td colspan="9" class="text-center">\
                                    <div class="spinner-border" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                    Sedang mengambil data...\
                                </td>\
                            </tr>\
                            ');

        const url = "{!! URL::to('/teacher/subject-teacher/assessment/getscore') !!}";

        $.ajax({
            url,
            type: 'POST',
            data: {
                assessmentGroupId: '{{$assessmentGroupId}}',
                subjectId: '{{$subject["id"]}}',
                studentGroupId: '{{$studentGroup["id"]}}',
                type: 'MINI_ASSESSMENT',
            },
            dataType: 'json',
            beforeSend: function() {
                //
            },
            error: function(error) {
                //
                $("#scoreDataLoading").hide();
            },
            success: function(response) {
                $('#scoreData').html(response);
                $("#scoreDataLoading").hide();
            }
        });
    }
    scoreIndex();

    function modeEdit(id) {
        $("#score-td-" + id).removeClass("column-white").addClass("column-grey");
        $("#score-input-" + id).removeClass("input-score-white").addClass("input-score-grey");
        $("#score-alert-" + id).empty();
    }

    function updateScore(id) {
        console.log($("#score-input-" + id).val())
        if ($("#score-input-" + id).val() === "") {
            return false
        }

        $("#score-td-" + id).removeClass("column-grey").addClass("column-white");
        $("#score-input-" + id).removeClass("input-score-grey").addClass("input-score-white");

        $("#score-alert-" + id).html('<div class="spinner-border" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                     </div>');

        // run save
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/update-score') !!}";
        let data = new Object();

        data = {
            id: id,
            score: $("#score-input-" + id).val(),
        };

        var form = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'POST',
            body: form,
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
            .then(response => response.json())
            .then(function(data) {
                $("#score-alert-" + id).html('<i class="kejar-soal-benar"></i>');

                setTimeout(function() {
                    $("#score-alert-" + id).empty();
                }, 2000);
            })
            .catch(function(error) {
                console.error(error);
            });
    }

    function viewCreateSchedule(idStudent, nameStudent) {
        studentId = idStudent;
        studentName = nameStudent;

        $('.nameStudent').html(nameStudent);

        var footerModal = `<div class="modal-footer justify-content-end">\
        <div>\
        <button class="btn btn-link" data-dismiss="modal">Batal</button>\
        <button class="btn btn-primary" id="createAssgin" onclick="createNewAssign()">Tugaskan</button>\
        </div>\
        </div>`;

        $('#footerModal').html(footerModal);

        $('#createSchedule').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    }

    function viewDelete() {
        $('.nameStudent').html(studentName);

        $('#deleteSchecule').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    }

    function closeDelete() {
        $('#deleteSchecule').modal('hide');

        $('#createSchedule').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    }

    function viewUpdateSchedule(idStudent, nameStudent, idSchedule, scheduleStart, scheduleFinish, token) {
        studentId = idStudent;
        studentName = nameStudent;
        scheduleId = idSchedule;
        $('.nameStudent').html(studentName);

        var footerModal = `<div class="modal-footer justify-content-between">\
        <div>\
        <button class="btn btn-danger" data-dismiss="modal" onclick="viewDelete()">Hapus</button>\
        </div>\
        <div>\
        <button class="btn btn-link" data-dismiss="modal">Batal</button>\
        <button class="btn btn-primary" id="updateAssign" onclick="updateAssign()">Simpan</button>\
        </div>\
        </div>`;

        $('#footerModal').html(footerModal);

        if (scheduleStart) {
            $('#choice-1').prop('checked', true);
            $('#choice-1-panel').show();
            $('#start_date').val(moment.parseZone(scheduleStart).format("DD/MM/YYYY"));
            $('#start_time').val(moment.parseZone(scheduleStart).format("HH:mm"));
        }

        if (scheduleFinish) {
            $('#choice-2').prop('checked', true);
            $('#choice-2-panel').show();
            $('#expiry_date').val(moment(scheduleFinish).format("DD/MM/YYYY"));
            $('#expiry_time').val(moment(scheduleFinish).format("HH:mm"));
        }

        if (token) {
            $('#choice-0').prop('checked', true);
            $('#choice-0-panel').show();
            $('#token').val(token);
        }

        $('#createSchedule').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    }

    function modalAssignShow(val, withValidation = false) {
        if (val === 2) {
            var valid = true;
            if (withValidation) {
                // check
                if ($('#choice-1').is(':checked')) {
                    if ($('#start_date').val().length == 0 || $('#start_time').val().length == 0) {
                        valid = false;
                    }
                }

                if ($('#choice-2').is(':checked')) {
                    if ($('#expiry_date').val().length == 0 || $('#expiry_time').val().length == 0) {
                        valid = false;
                    }
                }

                if ($('#choice-0').is(':checked')) {
                    if ($('#token').val().length == 0) {
                        valid = false;
                    }
                }

            }
            if (valid) {
                $(".assignStudentsModalSection").modal('hide');
                $("#assignStudentsModal-" + val).modal('show');
            } else {
                alert('silahkan lengkapi data');
            }
        } else if (val === 3) {
            $(".assignStudentsModalSection").modal('hide');
            if ($('#choice-Assign1').is(':checked')) {
                // by Student Group
                $("#assignStudentsModal-3-studentGroup").modal('show');
            } else {
                // by Student NIS
                $("#assignStudentsModal-3-students").modal('show');
            }
        } else {
            $(".assignStudentsModalSection").modal('hide');
            $("#assignStudentsModal-" + val).modal('show');
        }
    }

    function modalAssignShowChoicePanel(val) {
        if ($('#choice-' + val).is(':checked')) {
            $("#choice-" + val + "-panel").show(200);
        } else {
            $("#choice-" + val + "-panel").hide(200);
        }
    }

    function createNewAssign() {
        var values = [];

        values.push(studentId);

        var start_date = '';
        var expiry_date = '';
        var token = '';

        if ($('#choice-1').is(':checked')) {
            var start_dateFormat = moment($('#start_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            start_date = start_dateFormat + ' ' + $('#start_time').val();
        }

        if ($('#choice-2').is(':checked')) {
            var expiry_dateFormat = moment($('#expiry_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            expiry_date = expiry_dateFormat + ' ' + $('#expiry_time').val();
        }

        if ($('#choice-0').is(':checked')) {
            token = $('#token').val();
        }

        let data = new Object();
        data = {
            type: 'ASSESSMENT',
            typeAssesment,
            data: values,
            token,
            assesment,
            start_date: start_date,
            expiry_date: expiry_date,
        };

        saveData(data);
    }

    function saveData(data) {
        $('#createAssgin').prop('disabled', true);
        $('#createAssgin').html('Tunggu...');

        const url = "{!! URL::to('/teacher/subject-teacher/schedules-create') !!}";

        var form = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'POST',
            body: form,
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
            .then(response => response.json())
            .then(function(data) {
                if (data.error) {
                    alert('Penyimpanan Gagal, Harap periksa kembali data yang dikirim.');
                    $('#createAssgin').prop('disabled', false);
                    $('#createAssgin').html('Tugaskan');
                    $('#choice-1').prop('checked', false);
                    $('#choice-1-panel').show();
                    $('#choice-2').prop('checked', false);
                    $('#choice-2-panel').show();
                    $('#choice-0').prop('checked', false);
                    $('#choice-0-panel').show();
                    $('#token').val("");
                    $('#start_date').val("");
                    $('#start_time').val("");
                    $('#expiry_date').val("");
                    $('#expiry_time').val("");
                } else {
                    scoreIndex();
                    $('#createSchedule').modal('hide');
                    $('#createAssgin').prop('disabled', false);
                    $('#createAssgin').html('Tugaskan');
                    $('#choice-1').prop('checked', false);
                    $('#choice-1-panel').show();
                    $('#choice-2').prop('checked', false);
                    $('#choice-2-panel').show();
                    $('#choice-0').prop('checked', false);
                    $('#choice-0-panel').show();
                    $('#token').val("");
                    $('#start_date').val("");
                    $('#start_time').val("");
                    $('#expiry_date').val("");
                    $('#expiry_time').val("");
                }
            })
            .catch(function(error) {
                console.log(error);
            });

    }

    function deleteData() {
        $('#deleteAssgin').prop('disabled', true);
        $('#deleteAssgin').html('Tunggu...');

        const url = "{!! URL::to('/teacher/subject-teacher/schedule-delete') !!}";

        $.ajax({
            url,
            type: 'POST',
            data: {
                scheduleId: scheduleId,
            },
            dataType: 'json',
            beforeSend: function() {
                //
            },
            error: function(error) {
                //
                $('#deleteAssgin').prop('disabled', false);
                $('#deleteAssgin').html('Hapus');
            },
            success: function(response) {
                scoreIndex();
                $('#deleteAssgin').prop('disabled', false);
                $('#deleteAssgin').html('Hapus');
                $('#deleteSchecule').modal('hide');
                $('#choice-1').prop('checked', false);
                $('#choice-1-panel').show();
                $('#choice-2').prop('checked', false);
                $('#choice-2-panel').show();
                $('#choice-0').prop('checked', false);
                $('#choice-0-panel').show();
                $('#token').val("");
                $('#start_date').val("");
                $('#start_time').val("");
                $('#expiry_date').val("");
                $('#expiry_time').val("");
            }
        });
    }

    function updateAssign() {

        var start_date = '';
        var expiry_date = '';
        var token = '';

        if ($('#choice-1').is(':checked')) {
            var start_dateFormat = moment($('#start_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            start_date = start_dateFormat + ' ' + $('#start_time').val();
        }

        if ($('#choice-2').is(':checked')) {
            var expiry_dateFormat = moment($('#expiry_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            expiry_date = expiry_dateFormat + ' ' + $('#expiry_time').val();
        }

        if ($('#choice-0').is(':checked')) {
            token = $('#token').val();
        }

        let data = new Object();
        data = {
            scheduleId: scheduleId,
            token,
            startDate: start_date,
            expiryDate: expiry_date,
            typeAssesment,
        };


        updateData(data);
    }

    function updateData(data) {
        $('#updateAssign').prop('disabled', true);
        $('#updateAssign').html('Tunggu...');

        const url = "{!! URL::to('/teacher/subject-teacher/schedule-update') !!}";

        var form = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'POST',
            body: form,
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
            .then(response => response.json())
            .then(function(data) {
                if (data.error) {
                    alert('Penyimpanan Gagal, Harap periksa kembali data yang dikirim.');
                    $('#updateAssign').prop('disabled', false);
                    $('#updateAssign').html('Simpan');
                    $('#choice-1').prop('checked', false);
                    $('#choice-1-panel').show();
                    $('#choice-2').prop('checked', false);
                    $('#choice-2-panel').show();
                    $('#choice-0').prop('checked', false);
                    $('#choice-0-panel').show();
                    $('#token').val("");
                    $('#start_date').val("");
                    $('#start_time').val("");
                    $('#expiry_date').val("");
                    $('#expiry_time').val("");
                } else {
                    scoreIndex();
                    $('#createSchedule').modal('hide');
                    $('#updateAssign').prop('disabled', false);
                    $('#updateAssign').html('Simpan');
                    $('#choice-1').prop('checked', false);
                    $('#choice-1-panel').show();
                    $('#choice-2').prop('checked', false);
                    $('#choice-2-panel').show();
                    $('#choice-0').prop('checked', false);
                    $('#choice-0-panel').show();
                    $('#token').val("");
                    $('#start_date').val("");
                    $('#start_time').val("");
                    $('#expiry_date').val("");
                    $('#expiry_time').val("");
                }
            })
            .catch(function(error) {
                console.log(error);
            });

    }

    function closeToken() {
        $('#tokenExplain').modal('hide');

        $('#createSchedule').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    }

    function viewToken() {
        $('#createSchedule').modal('hide');

        $('#tokenExplain').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    }
</script>
@endpush