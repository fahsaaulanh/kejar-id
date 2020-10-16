@extends('layout.index')

@section('title', $miniAssessmentGroup)

@section('content')
    <div class="container-lg">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/games') }}">
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
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive table-result-stage">
                    <table class="table table-bordered" id="table-kejar">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>Paket</th>
                                <th>Durasi</th>
                                <th>Nilai Rekomendasi</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody id="scoreData">
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    Sedang mengambil data...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                                <td colspan="6" class="text-center">\
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
</script>
@endpush
