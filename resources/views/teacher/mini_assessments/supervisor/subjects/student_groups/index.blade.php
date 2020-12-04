@extends('layout.index')

@section('title', $miniAssessmentGroup)

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/supervisor/mini-assessment/'.$miniAssessmentGroupValue) }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/supervisor/mini-assessment/'.$miniAssessmentGroupValue) }}">{{$miniAssessmentGroup}}</a>
            <span class="breadcrumb-item active">{{$subject['name']}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{$subject['name']}} - Kelas {{ $grade }}</h2>
        </div>
        <ul class="nav nav-justified nav-tab-kejar">
            <li class="nav-item">
                <a class="nav-link" id="nav-score-tab" data-toggle="{{ $reportAccess ? 'pill' : ''}}" href="#nav-score" role="tab" aria-controls="nav-score" aria-selected="false">Nilai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="nav-questions-tab" data-toggle="pill" href="#nav-questions" role="tab" aria-controls="nav-questions" aria-selected="false">Soal</a>
            </li>
        </ul>
        <div class="tab-content pt-5" id="nav-tabContent">
            <div class="tab-pane" id="nav-score" role="tabpanel" aria-labelledby="nav-score-tab">
                <div id="schoolGroupDataLoading">
                    <div class="row justify-content-center">
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang mengambil data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang mengambil data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang mengambil data...</span>
                        </div>
                    </div>
                    <div class="mt-2 row justify-content-center">
                        <h5>Sedang mengambil data...</h5>
                    </div>
                </div>
                <div id="schoolGroupData"></div>
            </div>
            <div class="tab-pane fade show active" id="nav-questions" role="tabpanel" aria-labelledby="nav-questions-tab">
                <div id="packageDataLoading">
                    <div class="row justify-content-center">
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang mengambil data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang mengambil data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang mengambil data...</span>
                        </div>
                    </div>
                    <div class="mt-2 row justify-content-center">
                        <h5>Sedang mengambil data...</h5>
                    </div>
                </div>
                <div id="packageData"></div>
            </div>
        </div>
    </div>
    @include('teacher.mini_assessments.subjects.subject_teachers._view')
@endsection


@push('script')

    <script type="text/javascript">

        function packageIndex(page = 1){
            $("#packageDataLoading").show();
            $("#packageData").empty();
            var miniAssessmentGroupValue = "{!! $miniAssessmentGroupValue !!}";
            var subjectId = "{!! $subjectId !!}";
            var grade = "{!! $grade !!}";

            const url = "{!! URL::to('/teacher/mini-assessment/index-package') !!}";
            let data  = new Object();

            data = {
                miniAssessmentGroupValue: miniAssessmentGroupValue,
                subjectId: subjectId,
                grade: grade,
                page: page,
                paginationFunction: "packageIndex"
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
                $('#packageData').html(data);
                $("#packageDataLoading").hide();
            })
            .catch(function(error) {
                console.error(error);
                $("#packageDataLoading").hide();
            });
        }
        packageIndex();

        function schoolGroupIndex(page = 1){
            $("#schoolGroupDataLoading").show();
            $("#schoolGroupData").empty();
            var miniAssessmentGroupValue = "{!! $miniAssessmentGroupValue !!}";
            var subjectId = "{!! $subjectId !!}";
            var grade = "{!! $grade !!}";

            const url = "{!! URL::to('/teacher/mini-assessment/index-school-group') !!}";
            let data  = new Object();

            data = {
                miniAssessmentGroupValue: miniAssessmentGroupValue,
                subjectId: subjectId,
                grade: grade,
                page: page,
                type: "supervisor",
                paginationFunction: "schoolGroupIndex"
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
                $('#schoolGroupData').html(data);
                $("#schoolGroupDataLoading").hide();
            })
            .catch(function(error) {
                console.error(error);
                $("#schoolGroupDataLoading").hide();
            });
        }
        if ('{{ $reportAccess }}') {
            schoolGroupIndex();
        }

        function viewMA(id){

            $('#loading').show();
            $('#ma-content').hide();

            const url = "{!! URL::to('/teacher/mini-assessment/view') !!}"+"/"+id;
            let data  = new Object();

            // data = {};

            var form    = new URLSearchParams(data);
            var request = new Request(url, {
                method: 'GET',
                // body: form,
                headers: new Headers({
                'Content-Type' : 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                })
            });

            fetch(request)
            .then(response => response.json())
            .then(function(data) {
                $('#choices').html(data.choices);
                $('#multipleChoices').html(data.multipleChoices);
                $('.headGroup').html(data.group);
                $('#headId').html(data.detail.id);
                $('#headTime').html(data.time);
                $('#ma-id').val(id);
                $('#headSubject').html('{{$subject['name']}}');
                $('#link-package').html('<a href="'+data.detail.pdf+'" target="_blank"><i class="kejar-pdf text-primary"></i> Lihat Naskah Soal</a>');

                if (data.detail.validated == 1){
                    $('#viewButton').html('<p>Telah divalidasi oleh '+data.detail.created+'.</p>');
                }else{
                    $('#viewButton').html('<button class="btn btn-revise" onclick="modalValidation()">Validasi</button>');
                }

                $('#loading').hide();
                $('#ma-content').show();
            })
            .catch(function(error) {
                console.error(error);
            });
        }

        function modalValidation() {
            $("#view-ma").modal('hide');
            $("#ma-validation").modal('show');
        }

        function attendanceForm(miniAssessmentGroupValue, subjectId, grade, batch_id, id, name){
            $("#attendance-form").modal('show');
            var html = '<tr>\
                            <td colspan="4">\
                                <div class="row justify-content-center">\
                                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>\
                                </div>\
                                <div class="mt-2 row justify-content-center">\
                                    <h5>Loading</h5>\
                                </div>\
                            </td>\
                        </tr>';
            $("#AttendanceStudentGroup").html(name);
            $("#AttendanceContent").html(html);

            const url = "{!! URL::to('/teacher/mini-assessment/attendance-form') !!}"+"/"+id;
            let data  = new Object();

            data = {
                mini_assessment_group: miniAssessmentGroupValue,
                subjectId: subjectId,
                grade: grade,
                batch_id: batch_id,
                id: id
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
                $("#AttendanceContent").html(data);
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
    </script>
@endpush
