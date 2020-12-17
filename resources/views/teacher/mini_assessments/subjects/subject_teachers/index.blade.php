@extends('layout.index')

@section('title', $miniAssessmentGroup)

@section('content')
<div class="container">

    <!-- Link Back -->
    <a class="btn-back" href="{{ url('/teacher/subject-teachers/mini-assessment/'.$miniAssessmentGroupValue) }}">
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
        <h2 class="mb-08rem">{{$subject['name']}} - Kelas {{ $grade }}</h2>
    </div>
    <ul class="nav nav-justified nav-tab-kejar">
        <li class="nav-item">
            <a class="nav-link" id="nav-score-tab" data-toggle="{{ $reportAccess ? 'pill' : ''}}" href="#nav-score" role="tab" aria-controls="nav-score" aria-selected="false">Nilai Siswa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="nav-package-tab" data-toggle="pill" href="#nav-package" role="tab" aria-controls="nav-package" aria-selected="false">Paket Soal</a>
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
        <div class="tab-pane fade show active" id="nav-package" role="tabpanel" aria-labelledby="nav-package-tab">
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
<div class="modal fade bd-example-modal-lg" id="attendance-form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Absensi Kelas <span id="AttendanceStudentGroup"></span></h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-1">
                    <div class="col-12">
                        <div class="table-responsive table-result-stage">
                            <table class="table table-bordered" id="table-kejar">
                                <tr class="table-head">
                                    <th width="1%">No</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Hadir</th>
                                </tr>
                                <tbody id="AttendanceContent">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('teacher.mini_assessments.subjects.subject_teachers._view')
<!-- tes view -->
@include('teacher.teacher.assessment.mini.answers._view_answer')
<!-- end tes view -->


@endsection


@push('script')

<script type="text/javascript">
    function packageIndex(page = 1) {
        $("#packageDataLoading").show();
        $("#packageData").empty();
        var miniAssessmentGroupValue = "{!! $miniAssessmentGroupValue !!}";
        var subjectId = "{!! $subjectId !!}";
        var grade = "{!! $grade !!}";

        const url = "{!! URL::to('/teacher/mini-assessment/index-package') !!}";
        let data = new Object();

        data = {
            miniAssessmentGroupValue: miniAssessmentGroupValue,
            subjectId: subjectId,
            grade: grade,
            page: page,
            paginationFunction: "packageIndex"
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
                $('#packageData').html(data);
                $("#packageDataLoading").hide();
            })
            .catch(function(error) {
                console.error(error);
                $("#packageDataLoading").hide();
            });
    }
    packageIndex();

    function schoolGroupIndex(page = 1) {
        $("#schoolGroupDataLoading").show();
        $("#schoolGroupData").empty();
        var miniAssessmentGroupValue = "{!! $miniAssessmentGroupValue !!}";
        var subjectId = "{!! $subjectId !!}";
        var grade = "{!! $grade !!}";

        const url = "{!! URL::to('/teacher/mini-assessment/index-school-group') !!}";
        let data = new Object();

        data = {
            miniAssessmentGroupValue: miniAssessmentGroupValue,
            subjectId: subjectId,
            grade: grade,
            page: page,
            paginationFunction: "schoolGroupIndex"
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

    function viewMA(id) {

        $('#loading').show();
        $('#ma-content').hide();

        const url = "{!! URL::to('/teacher/mini-assessment/view') !!}" + "/" + id;
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
                $('#choices').html(data.choices);
                $('#multipleChoices').html(data.multipleChoices);
                $('.headGroup').html(data.group);
                $('#headId').html(data.detail.id);
                $('#headTime').html(data.time);
                $('#ma-id').val(id);
                $('#headSubject').html(`{{ $subject['name'] }}`);
                $('#link-package').html('<a href="' + data.detail.pdf + '" target="_blank"><i class="kejar-pdf text-primary"></i> Lihat Naskah Soal</a>');

                if (data.detail.validated == 1) {
                    $('#viewButton').html('<p>Telah divalidasi oleh ' + data.detail.created + '.</p>');
                } else {
                    $('#viewButton').html('<button class="btn btn-revise" onclick="modalValidation()">Validasi</button>');
                }

                $('#loading').hide();
                $('#ma-content').show();
            })
            .catch(function(error) {
                console.error(error);
            });
    }

    // view tes
    function viewMATes(id) {

        $('#loading-view').show();
        $('#ma-content-view').hide();

        const url = "{!! URL::to('/teacher/mini-assessment/tesview') !!}" + "/" + id;
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

                var naskahHtml = '<div onclick="viewNaskah(' + data.detail.pdf + ')" class="pts-btn-pdf" role="button">\
                <i class="kejar-pdf"></i>\
                <h4 class="text-reguler ml-4">Lihat Naskah Soal</h4></div>';

                $('.headGroup').html(data.group);
                $('.title-view').html(data.detail.title);
                $('.duration-view').html(`${data.detail.duration} Menit`);
                $('#token').html(data.detail.id);
                $('#headTime').html(data.time);
                $('#ma-id').val(id);
                $('#headSubject-view').html(`{{ $subject['name'] }}`);
                $('.view-naskah').html(naskahHtml);

                $('.tab-1-view').html(data.choicesTab1);
                $('.tab-2-view').html(data.choicesTab2);

                if (data.detail.validated == 1) {
                    $('#viewButton').html('<p>Telah divalidasi oleh ' + data.detail.created + '.</p>');
                } else {
                    $('#viewButton').html('<button class="btn btn-revise" onclick="modalValidation()">Validasi</button>');
                }

                $('#loading-view').hide();
                $('#ma-content-view').show();
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

    async function onClickAnswerPG(order, choice, id, number) {
        for (let i = 1; i < number; i++) {
            $(`#pts-choice-${order}-${i}`).removeClass('active');
        }

        $(`#pts-choice-${order}-${choice}`).addClass('active');

        $(`#pts-choice-load-${order}`).delay(1000).show(500);

        await setTimeout(function() {
            $(`#pts-choice-load-${order}`).show();
        }, 3000);

        await setTimeout(function() {
            $(`#pts-choice-load-${order}`).hide();
            $(`#pts-choice-success-${order}`).show();
        }, 3000);
    }
    // end view tes

    function modalValidation() {
        $("#view-ma").modal('hide');
        $("#ma-validation").modal('show');
    }

    function attendanceForm(miniAssessmentGroupValue, subjectId, grade, batch_id, id, name) {
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

        const url = "{!! URL::to('/teacher/mini-assessment/attendance-form') !!}" + "/" + id;
        let data = new Object();

        data = {
            mini_assessment_group: miniAssessmentGroupValue,
            subjectId: subjectId,
            grade: grade,
            batch_id: batch_id,
            id: id
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
                $("#AttendanceContent").html(data);
            })
            .catch(function(error) {
                console.error(error);
            });
    }


    function changePresence(id, presence, value) {

        // run save

        $("#presenceBtn-" + id).html('<div class="spinner-border mr-1" role="status">\
                                                <span class="sr-only">Loading...</span>\
                                            </div>Proses\
                                            ');

        const url = "{!! URL::to('/teacher/mini-assessment/update-presence') !!}";
        let data = new Object();

        data = {
            id: id,
            presence: presence,
            value: value,
            subject_id: "{{$subject['id']}}",
            mini_assessment_group_id: "{{$miniAssessmentGroupId}}",
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
                $("#presenceBtn-" + data.id).html(data.btn);
            })
            .catch(function(error) {
                console.error(error);
            });
    }
</script>
@endpush
