<!-- Modal Tugaskan Siswa -->

<div class="modal fade assignStudentsModalSection" id="assignStudentsModal-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tugaskan Siswa<br>
                    <small>1/2 Atur Jadwal</small>
                </h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @if($type == 'MINI_ASSESSMENT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title" class="font-weight-bold">Token/Password PDF</label>
                                    @if($assessments[0]['pdf_password'])
                                        <input type="text" class="form-control" name="title" value="{{$assessments[0]['pdf_password']}}" readonly disabled>
                                    @else
                                        <p class="text-grey">Tidak ada token/password.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="check-group row">
                                    <input type="checkbox" onchange="modalAssignShowChoicePanel(0)" id="choice-0" value="1" class="col-1 mt-2">
                                    <label for="choice-0" class="col pl-0">
                                    Penilaian hanya dapat dibuka dengan <b>token</b> yang diberikan secara manual oleh guru/pengawas.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none;" id="choice-0-panel">
                            <div class="col-1"></div>
                            <div class="col pl-0">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="title" class="font-weight-bold">Token</label><br>
                                        <small class="text-muted">
                                            Ketik token/password yang digunakan pada penilaian (jika ada).
                                            <span class="text-primary" onclick="modalAssignShow(4)" style="cursor:pointer">Pelajari</span>
                                        </small>
                                        <input type="text" class="form-control" name="title" value="" placeholder="Ketik token, 6 karakter a-z dan/atau 0-9" id="token">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif()
                    <div class="row">
                        <div class="col-12">
                            <div class="check-group row">
                                <input type="checkbox" onchange="modalAssignShowChoicePanel(1)" id="choice-1" value="1" class="col-1 mt-2">
                                <label for="choice-1" class="col pl-0">
                                    Penilaian hanya dapat dikerjakan <b>mulai dari</b> waktu tertentu.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;" id="choice-1-panel">
                        <div class="col-1"></div>
                        <div class="col pl-0">
                            <div class="row">
                                <div class="col-12">
                                    <label for="title" class="font-weight-bold">Dimulai Pada</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker text-dark"  placeholder="DD/MM/YYYY" id="start_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control clockpicker text-dark" placeholder="HH:MM" id="start_time" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="check-group row">
                                <input type="checkbox" onchange="modalAssignShowChoicePanel(2)" id="choice-2" value="1" class="col-1 mt-2">
                                <label for="choice-2" class="col pl-0">
                                Penilaian hanya dapat dikerjakan <b>sampai dengan</b> tanggal dan waktu tertentu.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="choice-2-panel" style="display:none;">
                        <div class="col-1"></div>
                        <div class="col pl-0">
                            <div class="row">
                                <div class="col-12">
                                    <label for="title" class="font-weight-bold">Selesai Pada</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker text-dark"  placeholder="DD/MM/YYYY" id="expiry_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control clockpicker text-dark" placeholder="HH:MM" id="expiry_time" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer text-right">
                <div class="text-right col-md-12">
                    <button class="btn btn-link pull-right" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary pull-right" onclick="modalAssignShow(2, true)">Lanjut</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-md assignStudentsModalSection" id="assignStudentsModal-4">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tentang Token</h5>
                <button class="close modal-close" onclick="modalAssignShow(1)">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-1">
                                1.
                            </div>
                            <div class="col">
                                Token tersebut berfungsi sebagai perlindungan tambahan untuk siswa membuka penilaian ketika penilaian berlangsung.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1">
                                2.
                            </div>
                            <div class="col">
                                Siswa harus menginput token sebelum membuka aktivitas penilaian.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1">
                                3.
                            </div>
                            <div class="col">
                                Sistem tidak akan menunjukkan token kepada siswa. Oleh karena itu, token dibagikan secara manual oleh guru/pengawas.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-right col-md-12">
                    <button class="btn btn-primary" onclick="modalAssignShow(1)">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/clockpicker/jquery-clockpicker.min.css')}}">
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/clockpicker/jquery-clockpicker.min.js')}}"></script>
    <script>

        var durationVal = "{{$assessments[0]['duration']}}";

        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy'
        });

        $('.clockpicker').clockpicker({
            placement: 'top',
            align: 'right',
            autoclose: true,
            'default': 'now'
        });

        var typeAssesment = "{{ $type }}";
        var assesment = [];

        if(typeAssesment == "MINI_ASSESSMENT"){

            var assesmentDatas = @json($assessments);
            $.each( assesmentDatas, function( key, value ) {
                assesment.push(value.id);
            });
        }else{

            var assesmentDatas = @json($assessments);
            assesment = assesmentDatas[0].id;
        }

        async function getStudents(student_group_id, checkAllFunc = false){
            if ($("#students-loading-"+student_group_id).length == 1) {
                $('#submitBtn').prop('disabled', true);
                const url = "{!! URL::to('/teacher/subject-teacher/get-students') !!}";
                let data  = new Object();
                var subject_id = "{{$subject['id']}}";
                data = {
                    student_group_id,
                    subject_id,
                    check: 'schedule'
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

                await fetch(request)
                .then(function (response) {
                    if(response.status == 302){
                        getStudents(student_group_id);
                    }
                    return response.json();
                })
                .then(function(data) {
                    if(data.data){
                        var checked = '';
                        if ($('#schedule-check-all-'+student_group_id).is(':checked')) {
                            checked = ' checked';
                        }
                        var html = '';
                        $.each( data.data, function( key, value ) {
                            var student_group_id_val = "'"+student_group_id+"'";
                            html += '<tr>';

                            if(value.already_scheduled){
                                html += '<td width="40px" class="text-center">\
                                <i class="kejar-checklist"></i>\
                                </td>';
                            }else{
                                html += '<td width="40px" class="text-center">\
                                <input name="student_data[]" type="checkbox" \
                                id="schedule-student-check-'+value.name+'" '+checked+' value="'+value.id+'"\
                                onclick="countStudents('+student_group_id_val+')"\
                                class="ml-1 unCheckedData students_group-'+student_group_id+'" checked></td>';
                            }
                                html += '<td width="50%"><label for="schedule-student-check-'+value.name+'">'+value.name+'</label></td>';
                                html += '<td><label for="schedule-student-check-'+value.name+'">'+value.nis+'</label></td>';
                            html += '</tr>';
                        });

                        $('#schedule-check-all-'+student_group_id).prop('checked', true);
                        $("#collapseStudents-"+student_group_id).empty();
                        $("#collapseStudents-"+student_group_id).append(html);
                        $("#students-loading-"+student_group_id).remove();
                        if ($('#schedule-check-all-'+student_group_id).is(':checked')) {
                            countStudents(student_group_id);
                        }
                    }else{
                        $("#schedule-check-all-"+student_group_id).remove();
                        $("#students-loading-"+student_group_id).html("<center>Tidak ada data<center>");
                    }

                    var totalVal = $(".total-students").html();
                    if (totalVal == 0) {
                        $('#submitBtn').prop('disabled', true);
                    }else{
                        $('#submitBtn').prop('disabled', checkAllFunc);
                    }

                })
                .catch(function(error) {
                    console.log(error);
                });
            }
        }
        var arrStudentGroup = [];

        function getStudentGroup(){

            $('#LoadingGetStudent').show(200);
            $("#studentGroupCheck").empty();

            const url = "{!! URL::to('/teacher/subject-teacher/get-student-group') !!}";
            let data  = new Object();

            var grade = {{ $grade }};

            data = {
                grade,
                htmlView: 'accordion'
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
                if(data.html){
                    arrStudentGroup = data.data;
                    $("#studentGroupCheck").append(data.html);
                }
                if(data.html == '<h2 class="text-center">Tidak Ada Data</h2>'){
                    $('#submitBtn').hide();
                }
                $('#LoadingGetStudent').hide(200);
            })
            .catch(function(error) {
                console.log(error);
            });
        }

        getStudentGroup();
        function modalAssignShow(val, withValidation = false){

            $('#duration-alert').hide();
            if(durationVal < 1){
                $(".assignStudentsModalSection").modal('hide');
                $('#duration').modal('show');
                $('#duration-alert').show();
                return;
            }

            if(val === 2){
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
                    $("#assignStudentsModal-"+val).modal('show');
                }else{
                    alert('silahkan lengkapi data');
                }
            }else if(val === 3){
                $(".assignStudentsModalSection").modal('hide');
                if ($('#choice-Assign1').is(':checked')) {
                    // by Student Group
                    $("#assignStudentsModal-3-studentGroup").modal('show');
                }else{
                    // by Student NIS
                    $("#assignStudentsModal-3-students").modal('show');
                }
            }else{
                $(".assignStudentsModalSection").modal('hide');
                $("#assignStudentsModal-"+val).modal('show');
            }
        }

        function modalAssignShowChoicePanel(val){
            if ($('#choice-'+val).is(':checked')) {
                $("#choice-"+val+"-panel").show(200);
            }else{
                $("#choice-"+val+"-panel").hide(200);
            }
        }

        function submit() {
            var values = $("input[name='student_data[]']:checked").map(function(){return $(this).val();}).get();
            var start_date = '';
            var expiry_date = '';
            var token = '';

            if ($('#choice-1').is(':checked')) {
                var start_dateFormat = moment($('#start_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
                start_date = start_dateFormat+' '+$('#start_time').val();
            }

            if ($('#choice-2').is(':checked')) {
                var expiry_dateFormat = moment($('#expiry_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
                expiry_date = expiry_dateFormat+' '+$('#expiry_time').val();
            }

            if ($('#choice-0').is(':checked')) {
                token = $('#token').val();
            }

            let data  = new Object();
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

        function submitStudent() {
            var values = $("#NISTextarea").val().split(',');

            var start_date = '';
            var expiry_date = '';
            var token = '';

            if ($('#choice-1').is(':checked')) {
                var start_dateFormat = moment($('#start_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
                start_date = start_dateFormat+' '+$('#start_time').val();
            }

            if ($('#choice-2').is(':checked')) {
                var expiry_dateFormat = moment($('#expiry_date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
                expiry_date = $('#expiry_date').val()+' '+$('#expiry_time').val();
            }

            if ($('#choice-0').is(':checked')) {
                token = $('#token').val();
            }

            let data  = new Object();
            data = {
                type: 'ASSESSMENT',
                typeAssesment,
                data: values,
                token,
                byNis: true,
                assesment,
                start_date: start_date,
                expiry_date: expiry_date,
            };

            saveData(data);
        }

        function saveData(data){

            // Check Duration

            if (durationVal < 1) {
                $(".assignStudentsModalSection").modal('hide');
                $('#duration').modal('show');
                return;
            }

            $('#submitBtn').prop('disabled', true);
            $('#submit').prop('disabled', true);
            $('.LoadingCreateSceduleStudents').show(200);

            const url = "{!! URL::to('/teacher/subject-teacher/schedules-create') !!}";

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
                if(data.error){
                    alert('Penyimpanan Gagal, Harap periksa kembali data yang dikirim.');
                    $('#submitBtn').prop('disabled', false);
                    $('#submit').prop('disabled', false);
                }else{
                    modalAssignShow('success');
                    getStudentGroup();
                    $('#schedule-check-all').prop('checked', false);
                    $('#NISTextarea').val('');
                    $('#submitBtn').prop('disabled', true);
                    $('#submit').prop('disabled', true);
                    $('.total-students').html(data.count_save);
                    $('.total-students-selected').html(0);
                }

                $('.LoadingCreateSceduleStudents').hide(200);
            })
            .catch(function(error) {
                console.log(error);
            });

        }

        function countStudents(student_group_id) {
            var total = $(".students_group-"+student_group_id+":checked").length;
            $(".count-students-group-"+student_group_id).html(total);

            var values = 0;
            $(".count-students-group").map(function(){
                values = parseInt(values) + parseInt($(this).html());
            });

            $(".total-students").html(values);
            var totalVal = $(".total-students").html();
            if (totalVal == 0) {
                $('#submitBtn').prop('disabled', true);
            }else{
                $('#submitBtn').prop('disabled', false);
            }
        }

        var doneCheckAll = false;

        function selectAllStudents(student_group_id) {
            if ($('#schedule-check-all-'+student_group_id).is( ":checked" )){
                $('.students_group-'+student_group_id).prop('checked', true);
                countStudents(student_group_id);
            }else{
                $('.students_group-'+student_group_id).prop('checked', false);
                $(".count-students-group-"+student_group_id).html(0);
                countStudents(student_group_id);
            }
        }

        async function scheduleCheckAll() {

            if ($('#schedule-check-all').is( ":checked" )) {
                if (doneCheckAll) {
                    $('.unCheckedData').prop('checked', true);

                    $.each( arrStudentGroup, function( key, value ) {
                        countStudents(value.id);
                    });

                }else{
                    const promisesEach = arrStudentGroup.map((d) => getStudents(d.id, true));

                    // Show loading
                    $('#LoadingGetStudent').show(200);

                    await Promise.all(promisesEach);
                    doneCheckAll = true;
                    $('#submitBtn').prop('disabled', false);

                    // Hide loading
                    $('#LoadingGetStudent').hide(200);

                }
            }else{
                $('.unCheckedData').prop('checked', false);
                $('.count-students-group').html(0);
                $('.total-students').html(0);
            }
            var totalVal = $(".total-students").html();
            if (totalVal == 0) {
                $('#submitBtn').prop('disabled', true);
                $('#submitBtnStudent').prop('disabled', true);
            }else{
                $('#submitBtn').prop('disabled', false);
                $('#submitBtnStudent').prop('disabled', false);
            }
            var totalVal = $(".total-students").html();
            if (totalVal == 0) {
                $('#submitBtn').prop('disabled', true);
            }else{
                $('#submitBtn').prop('disabled', false);
            }
            var totalVal = $("#total-students").html();
            if (totalVal == 0) {
                $('#submitBtn').prop('disabled', true);
            }else{
                $('#submitBtn').prop('disabled', false);
            }
        }
    </script>
@endpush
