@extends('layout.index')

@section('title', $assessmentGroup)

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/supervisor/'.$assessmentGroupValue.'/subject') }}">
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
            <h2 class="mb-08rem">{{$subject['name']}} - Kelas {{ $grade }}</h2>
        </div>
        <div class="row">
            <div class="col">
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
        </div>
    </div>
@endsection


@push('script')

    <script type="text/javascript">
        function schoolGroupIndex(page = 1){
            $("#schoolGroupDataLoading").show();
            $("#schoolGroupData").empty();
            var assessmentGroupValue = "{!! $assessmentGroupValue !!}";
            var subjectId = "{!! $subjectId !!}";
            var grade = "{!! $grade !!}";

            const url = "{!! URL::to('/teacher/supervisor/' . $assessmentGroupValue . '/student-group') !!}";
            let data  = new Object();

            data = {
                assessmentGroupValue: assessmentGroupValue,
                subjectId,
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
        schoolGroupIndex();

    </script>
@endpush
