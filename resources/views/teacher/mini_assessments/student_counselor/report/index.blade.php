@extends('layout.index')

@section('title', $miniAssessmentGroup)

@section('content')
<div class="container-lg">

    <!-- Link Back -->
    <a class="btn-back" href="{{ URL('teacher/'.$type.'/mini-assessment/'.$miniAssessmentGroupValue.'/list') }}">
        <i class="kejar-back"></i>Kembali
    </a>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ URL('teacher/'.$type.'/mini-assessment/'.$miniAssessmentGroupValue.'/list') }}">
            {{$miniAssessmentGroup}}
        </a>
        <span class="breadcrumb-item active">{{$studentCounselor['name']}}</span>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">{{$studentCounselor['name']}}</h2>
    </div>

    <div class="content-body">
        <!-- ICON-STATUS -->
        <div class="score-description">
            <div class="align-items-center"> Keterangan:</div>
            <div class="align-items-center"> NR = Nilai Rekomendasi</div>
            <div class="align-items-center"> NA = Nilai Akhir</div>
        </div>

        <div class="table-responsive table-result-stage">
            <table class="table table-bordered" id="table-kejar">
                <tr class="table-head">
                    <th rowspan="2" width="30%">Nama Siswa</th>
                    <th rowspan="2" width="30%">Rombel</th>
                    @foreach($subjects as $key => $v)
                        <th colspan="2">{{$v}}</th>
                    @endforeach()
                </tr>
                <tr class="table-head">
                    @for ($i=0; $i < count($subjects); $i++)
                        <th>NR</th>
                        <th>NA</th>
                    @endfor
                </tr>
                <tbody id="scoreData">
                </tbody>
            </table>
        </div>
        <div id="pagination"></div>
    </div>
</div>
@endsection


@push('script')
<script>

    var studentData = [];

    function getStudent(page = 1) {

        var count_subjects = "{{count($subjects)}}";
        $("#pagination").html("");

        $("#scoreData").html('<tr>\
                                <td colspan="'+((count_subjects * 2) + 2)+'">\
                                    <div class="spinner-border mr-1" role="status">\
                                        <span class="sr-only">Loading...</span>\
                                    </div>Sedang Mengambil Data\
                                </td>\
                              </tr>');

        const url = "{!! URL::to('/teacher/mini-assessment/counselor-students') !!}";
        let data  = new Object();

        data = {
            student_counselor_id: "{{$studentCounselor['id']}}",
            count_subjects,
            page: page
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
                studentData = data.data;
                $("#scoreData").html(data.html);
                $("#pagination").html(data.pgnt);
                getScore();
            }else{

                $("#scoreData").html('<tr>\
                                        <td colspan="'+((count_subjects * 2) + 2)+'">\
                                            Tidak ada data\
                                        </td>\
                                    </tr>');
            }
        })
        .catch(function(error) {
        });
    }

    async function getScoreStudent(studentId){

        if($("#score-loading-"+studentId).is(":hidden")){
            return true;
        }

        $("#score-loading-"+studentId)
            .html('<div class="spinner-border mr-1" role="status">\
                <span class="sr-only">Loading...</span>\
            </div> Loading');

        const url = "{!! URL::to('/teacher/mini-assessment/student-score') !!}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var request = {
            studentId,
            subjects: @json($subjects)
        }

        await $.ajax({
            method: 'post',
            data: request,
            url: url,
            success: function (response) {
                if(response.status == 200){
                    $("#score-loading-"+studentId).hide();
                    $("#score-"+studentId).after(response.html);
                }else{
                    $("#score-loading-"+studentId).html("Tidak ada data");
                }
            },
            error: function (error) {
                $("#score-loading-"+studentId)
                .html('<span class="btn btn-primary"\
                        onclick="getScore()">\
                        Coba Kembali dapatkan nilai\
                       </span>');
            }
        });
    }

    async function getScore(){
        const promisesSave = studentData.map((d) => getScoreStudent(d.id));
        await Promise.all(promisesSave);
    }
    getStudent();
</script>
@endpush
