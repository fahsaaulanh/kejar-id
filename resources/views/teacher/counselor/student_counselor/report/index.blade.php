@extends('layout.index')

@section('title', $assessmentGroup)

@section('content')
    <div class="container-lg">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/student-counselor/'.$assessmentGroupId.'/counseling-groups/') }}">{{$assessmentGroup}}</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/student-counselor/'.$assessmentGroupId.'/counseling-groups/'.$studentCounselor['id'].'/subject') }}">{{$studentCounselor['name']}}</a>
            <span class="breadcrumb-item active">{{$subject['name']}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{$subject['name']}}</h2>
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

        <div class="row">
            <div class="col">
                <ul class="nav nav-justified nav-tab-kejar" id="myTab" role="tablist">
                    <li class="nav-item w-50 text-center" role="presentation">
                        <a class="nav-link active" id="grade-10-tab" data-toggle="tab" href="#grade-10" role="tab" aria-controls="grade-10" aria-selected="true">Kelas X</a>
                    </li>
                    <li class="nav-item w-50 text-center" role="presentation">
                        <a class="nav-link" id="grade-11-tab" data-toggle="tab" href="#grade-11" role="tab" aria-controls="grade-11" aria-selected="false">Kelas XI</a>
                    </li>
                    <li class="nav-item w-50 text-center" role="presentation">
                        <a class="nav-link" id="grade-12-tab" data-toggle="tab" href="#grade-12" role="tab" aria-controls="grade-12" aria-selected="false">Kelas XII</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    @for($i=10; $i < 13; $i++)
                        <div class="tab-pane fade show @if($i === 10) active @endif" id="grade-{{$i}}" role="tabpanel" aria-labelledby="grade-{{$i}}-tab">
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive table-result-stage">
                                        <table class="table table-bordered" id="table-kejar">
                                            <tr class="table-head">
                                                <th width="10%">No</th>
                                                <th>Nama</th>
                                                <th>NIS</th>
                                                <th>Rombel</th>
                                                <th>Nilai Rekomendasi</th>
                                                <th>Nilai Akhir</th>
                                            </tr>
                                            <tbody id="scoreData-{{$i}}">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="pagination-{{$i}}"></div>
                                </div>
                            </div>
                        </div>
                    @endFor
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>

        var assessment_group_id = "{{$assessmentGroupId}}";
        var subject_id = "{{$subject['id']}}";
        var studentData = [];

        function getScore(grade, page = 1) {

            $("#pagination").html("");

            $("#scoreData-"+grade).html('<tr>\
                                    <td colspan="6" class="text-center">\
                                        <div class="spinner-border mr-1" role="status">\
                                            <span class="sr-only">Loading...</span>\
                                        </div>Sedang Mengambil Data\
                                    </td>\
                                </tr>');

            const url = "{!! URL::to('/teacher/student-counselor/report-student') !!}";
            let data  = new Object();

            data = {
                student_counselor_id: "{{$studentCounselor['id']}}",
                grade,
                assessment_group_id,
                subject_id,
                paginationFunction: "getScore",
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
                    $("#scoreData-"+grade).html(data.html);
                    $("#pagination-"+grade).html(data.pgnt);
                }else{

                    $("#scoreData-"+grade).html('<tr>\
                                            <td colspan="6" class="text-center">\
                                                Tidak ada data\
                                            </td>\
                                        </tr>');
                }
            })
            .catch(function(error) {
            });
        }
        getScore(10);
        getScore(11);
        getScore(12);
    </script>
@endpush
