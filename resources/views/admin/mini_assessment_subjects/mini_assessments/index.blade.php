@extends('layout.index')

@section('title', $miniAssessmentGroup)

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/admin/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/admin/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/admin/mini-assessment/'.$miniAssessmentGroupValue) }}">{{$miniAssessmentGroup}}</a>
            <span class="breadcrumb-item active">{{$subject['name']}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{$subject['name']}} - Kelas {{ $grade }}</h2>
        </div>

        <div id="alert-upload"></div>

        <div class="upload-buttons">
            <button class="btn-upload" data-toggle="modal" data-target="#add-ma">
                <i class="kejar-add"></i>Tambah Paket
            </button>
            <button class="btn-upload" data-toggle="modal" data-target="#upload-ma-answer">
                <i class="kejar-upload"></i>Unggah Jawaban
            </button>
        </div>
        <!-- List of Stages (Admin)-->
        <div class="list-group" data-url="#" data-token="{{ csrf_token() }}">

            @forelse($miniAssessmentIndex as $key => $v)
                <div class="list-group-item" data-id="{{$v['id']}}">
                    <a href="javascript:void(0)" class="col-12">
                        <i class="kejar-link" data-id="{{$v['id']}}" data-container="body" data-toggle="popover" data-placement="top" data-content="ID disalin!"></i>
                        <span data-toggle="modal" data-target="#view-ma" onclick="viewMA('{{$v['id']}}')">{{$v['title']}}</span>
                        <i class="kejar-right float-right" data-toggle="modal" onclick="viewMA('{{$v['id']}}')" data-target="#view-ma"></i>
                    </a>
                </div>
            @empty
                <h5 class="text-center">Tidak ada data</h5>
            @endforelse

        </div>

    </div>
@include('admin.mini_assessment_subjects.mini_assessments._create')
@include('admin.mini_assessment_subjects.mini_assessments._upload_answer')
@include('admin.mini_assessment_subjects.mini_assessments._view')
@endsection


@push('script')
    <script src="{{ mix('/js/admin/stage/script.js') }}"></script>

    <script type="text/javascript">

        function viewMA(id){

            $('#loading').show();
            $('#ma-content').hide();

            const url = "{!! URL::to('/admin/mini-assessment/view') !!}"+"/"+id;
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
                $('#headSubject').html('{{$subject['name']}}');
                $('#link-package').html('<a href="'+data.detail.pdf+'" target="_blank"><i class="kejar-pdf text-primary"></i> Lihat Naskah Soal</a>');

                $('#loading').hide();
                $('#ma-content').show();
            })
            .catch(function(error) {
                console.error(error);
            });
        }

        function showLoadingCreate(){
            $("#LoadingCreate").show();
        }

        $("#UploadAnswers").on('submit', function(event){
            event.preventDefault();

            $("#loading_upload_file").show();
            const file = document.getElementById('upload_file')

            const url = "{!! URL::to('/admin/mini-assessment/upload-answers') !!}";

            var myformData = new FormData();
            myformData.append('file', file.files[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: myformData,
                enctype: 'multipart/form-data',
                url: url,
                success: function (response) {
                    saveAll(response);
                }
            });
        });

        async function fetchSubjects(data) {
            const url = "{!! URL::to('/admin/mini-assessment/create-answers') !!}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            await $.ajax({
                method: 'post',
                data: data,
                url: url,
                success: function (response) {
                }
            });
        }

        async function saveAll(data) {
            const promisesSave = data.map((d) => fetchSubjects(d));

            await Promise.all(promisesSave);
            $("#upload-ma-answer").modal('toggle');

            var alert = '';
            alert += '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                alert += '<strong>Sukses!</strong> Upload jawaban berhasil.';
                alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                    alert += '<span aria-hidden="true">&times;</span>';
                alert += '</button>';
            alert += '</div>';

            $("#alert-upload").html(alert);
            $("#loading_upload_file").hide();
        }

    </script>
@endpush
