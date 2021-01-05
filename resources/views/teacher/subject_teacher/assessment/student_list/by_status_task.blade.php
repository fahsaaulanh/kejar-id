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
        <a class="breadcrumb-item active" href="{{ url('/teacher/'.$teacherType.'/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment') }}">{{$subject['name']}}</a>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">Siswa Belum Mengerjakan</h2>
    </div>
    <div class="row justify-content-between align-items-end">
        <div class="col-6">
        </div>
        <div class="col-6">
            <div class="row justify-content-end pr-4">
                <div>
                    <button class="btn btn-lg btn-skip btn-publish mr-4" onclick="editData()"><i class="kejar-edit text-primary mr-1"> </i> Edit Penugasan</button>
                </div>
                <div>
                    <button onclick="getData()" class="btn btn-publish"><i class="kejar-reload text-white mr-1"> </i> Refresh Halaman</button>
                </div>
            </div>

        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr class="table-head">
                        <th>Rombel</th>
                        <th width="5%">No.</th>
                        <th width="5%">Pilih</th>
                        <th>Nama</th>
                        <th>NIS</th>
                    </tr>
                    <tbody id="data">
                    </tbody>
                </table>
            </div>
            <div id="pagination"></div>
        </div>
    </div>
</div>

@include('teacher.subject_teacher.assessment.score._about_token')
@include('teacher.subject_teacher.assessment.student_list._delete_schedule')
@include('teacher.subject_teacher.assessment.student_list._setting_schedule')

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/clockpicker/jquery-clockpicker.min.css')}}">
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/clockpicker/jquery-clockpicker.min.js')}}"></script>
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var typeAssesment = "{{ $type }}";
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

        $("#data").html('<tr>\
            <td colspan="5" class="text-center">\
                <div class="spinner-border" role="status">\
                    <span class="sr-only">Loading...</span>\
                </div>\
                Sedang mengambil data...\
            </td>\
        </tr>\
        ');

        function getData(page = 1) {

            const url = "{!! URL::to('/teacher/subject-teacher/assessment/schedule/student-list') !!}";
            let data = new Object();

            data = {
                assessment_group_id: "{{ $assessmentGroupId }}",
                subject_id: "{{ $subject['id'] }}",
                grade: "{{ $grade }}",
                status_task: "Undone",
                group: "student_group",
                paginationFunction: "getData",
                page
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

            $("#data").empty();
            $("#pagination").empty();

            $("#data").html('<tr>\
                <td colspan="5" class="text-center">\
                    <div class="spinner-border" role="status">\
                        <span class="sr-only">Loading...</span>\
                    </div>\
                    Sedang mengambil data...\
                </td>\
            </tr>\
            ');

            fetch(request)
                .then(response => response.json())
                .then(function(data) {
                    console.log(data);
                    $("#data").html(data.table);
                    $("#pagination").html(data.pagination);

                })
                .catch(function(error) {
                    console.error(error);
                });
        }

        getData();

        function viewDelete() {
            $('#updateSchedule').modal('hide');
            $('#deleteSchecule').modal({
                backdrop: 'static',
                keyboard: false,
                show: true,
            });
        }

        function closeDelete() {
            $('#deleteSchecule').modal('hide');
            $('#updateSchedule').modal({
                backdrop: 'static',
                keyboard: false,
                show: true,
            });
        }

        function viewToken() {
            $('#updateSchedule').modal('hide');

            $('#tokenExplain').modal({
                backdrop: 'static',
                keyboard: false,
                show: true,
            });
        }

        function closeToken() {
            $('#tokenExplain').modal('hide');

            $('#updateSchedule').modal({
                backdrop: 'static',
                keyboard: false,
                show: true,
            });
        }

        async function deleteFunc(scheduleId) {

            const url = "{!! URL::to('/teacher/subject-teacher/schedule-delete') !!}";

            await $.ajax({
                url,
                type: 'POST',
                data: {
                    scheduleId,
                },
                dataType: 'json',
                beforeSend: function() {
                    //
                },
                error: function(error) {
                    //
                    $('#deleteAssgin').prop('disabled', false);
                    $('#deleteAssgin').html('Hapus');
                    return false;
                },
                success: function(response) {
                    return true;
                }
            });
        }

        async function deleteData() {
            $('#deleteAssgin').prop('disabled', true);
            $('#deleteAssgin').html('Tunggu...');

            var scheduleIds = getIdStudentChecked();

            const promisesEach = scheduleIds.map((d) => deleteFunc(d));

            await Promise.all(promisesEach);

            getData();
            $('#deleteAssgin').prop('disabled', false);
            $('#deleteAssgin').html('Hapus');
            $('#deleteSchecule').modal('hide');
            $('#choice-1').prop('checked', false);
            $('#choice-1-panel').hide();
            $('#choice-2').prop('checked', false);
            $('#choice-2-panel').hide();
            $('#choice-0').prop('checked', false);
            $('#choice-0-panel').hide();
            $('#token').val("");
            $('#start_date').val("");
            $('#start_time').val("");
            $('#expiry_date').val("");
            $('#expiry_time').val("");

        }

        function modalAssignShowChoicePanel(val){
            if ($('#choice-'+val).is(':checked')) {
                $("#choice-"+val+"-panel").show(200);
            }else{
                $("#choice-"+val+"-panel").hide(200);
            }
        }

        function editData() {
            $("#updateSchedule").modal('show');
        }

        function getIdStudentChecked() {
            var ids = [];
            $('.studentChecked:checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            return ids;
        }

        function updateAssign() {
            var scheduleId = getIdStudentChecked();

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

            if ($('#choice-1').is(':checked') && $('#choice-2').is(':checked')) {
                var start_dateFormat = moment($('#start_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
                var start_date = start_dateFormat+' '+$('#start_time').val();

                var expiry_dateFormat = moment($('#expiry_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
                var expiry_date = expiry_dateFormat+' '+$('#expiry_time').val();

                if (start_date >= expiry_date) {
                    alert('Waktu tidak sesuai, silahkan diperbaiki.');
                    return;
                }

            }

            let data = new Object();
            data = {
                scheduleId,
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
                    $('#updateAssign').html('Tugaskan');
                    $('#choice-1').prop('checked', false);
                    $('#choice-1-panel').hide();
                    $('#choice-2').prop('checked', false);
                    $('#choice-2-panel').hide();
                    $('#choice-0').prop('checked', false);
                    $('#choice-0-panel').hide();
                    $('#token').val("");
                    $('#start_date').val("");
                    $('#start_time').val("");
                    $('#expiry_date').val("");
                    $('#expiry_time').val("");
                } else {
                    getData();
                    $('#updateSchedule').modal('hide');
                    $('#updateAssign').prop('disabled', false);
                    $('#updateAssign').html('Tugaskan');
                    $('#choice-1').prop('checked', false);
                    $('#choice-1-panel').hide();
                    $('#choice-2').prop('checked', false);
                    $('#choice-2-panel').hide();
                    $('#choice-0').prop('checked', false);
                    $('#choice-0-panel').hide();
                    $('#token').val("");
                    $('#start_date').val("");
                    $('#start_time').val("");
                    $('#expiry_date').val("");
                    $('#expiry_time').val("");
                }
            })
            .catch(function(error) {
            });
        }

    </script>
@endpush
