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
            <div class="row justify-content-end">
                <div class="pr-4">
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
                        <th width="10%">No.</th>
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

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/clockpicker/jquery-clockpicker.min.css')}}">
@endsection

@push('script')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/clockpicker/jquery-clockpicker.min.js')}}"></script>
    <script type="text/javascript">

        $("#data").html('<tr>\
            <td colspan="4" class="text-center">\
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
                <td colspan="4" class="text-center">\
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
    </script>
@endpush
