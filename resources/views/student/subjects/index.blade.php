@extends('layout.index')

@section('title', 'PTS')

@section('content')
    <div class="container">
        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('student/dashboard') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('student/dashboard') }}">Beranda</a>
            <span id="breadcrumb-1" class="breadcrumb-item active"></span>
        </nav>
        <!-- Title -->
        <div class="page-title">
            <h2 id="title" class="mb-08rem"></h2>
        </div>
        <!-- <form disabled>
            <div class="row mb-5">
                <div class="col-10 p-0">
                    <div class="input-group">
                        <span class="input-group-append">
                            <h2 class="border-right-0 border pt-1 pl-1">
                                <i class="kejar-search text-muted"></i>
                            </h2>
                        </span>
                        <input placeholder="Cari Nama Mapel" class="form-control py-2 border-left-0 border" id="subject-name" type="search">
                    </div>
                </div>
                <div class="col-2">
                    <span class="btn btn-revise btn-block bg-white" onclick="subjectIndex()">
                        <span>Cari</span>
                    </span>
                </div>
            </div>
        </form> -->
        <div class="accordion" id="accordion-pts">
            <!-- Empty -->
        </div>
    </div>
    <div class="modal fade bd-example-modal-md" id="view-detail">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Mapel</h5>
                    <button class="close modal-close" data-dismiss="modal">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="viewDetailContent">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('student.subjects._schedule_not_started')
@include('student.subjects._schedule_over')
@include('student.subjects._task_done')

@push('script')
<script>

    const title = localStorage.getItem('pts_title') || '';
    $('#breadcrumb-1').html(title);
    window.document.title = `${title}`;

    function viewDetail(id, name) {
        // $("#view-detail").modal('show');
        $("#viewDetailContent").html(`
            <div class="row justify-content-center">
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="mt-2 row justify-content-center">
                <h5>Loading</h5>
            </div>
        `);

        const url = "{!! URL::to('/student/subjects/view-detail') !!}";
        let data  = new Object();

        data = {
            id: id,
            name: name
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
            $("#viewDetailContent").html(data);
        })
        .catch(function(error) {
            var view = '<div class="row px-7 mt-4">\
                            <div class="row bg-light py-2 w-100 p-4">\
                                <h4 class="text-reguler col-12 text-center">\
                                Periksa Koneksi Anda. \
                                <a href="javascript:void(0)" \
                                onclick="viewDetail(\''+id+'\',\''+name+'\')"\
                                class="btn btn-primary btn-lg mt-2">\
                                Tampilkan Detail Mapel </a></h4>\
                            </div>\
                        </div>';
            $('#viewDetailContent').html(view);
        });
    }

    function subjectIndex(page = 1){
        $("#accordion-pts").html(`
            <div class="row justify-content-center">
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="mt-2 row justify-content-center">
                <h5>Loading</h5>
            </div>
        `);

        const url = "{!! URL::to('/student/subjects/get-subject') !!}";
        let data  = new Object();

        data = {
            page: page,
            paginationFunction: 'subjectIndex'
            // subject_name: $("#subject-name").val(),
            // mini_assessment: localStorage.getItem('pts_title')
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
            $('#accordion-pts').html(data);
        })
        .catch(function(error) {
            var view = '<div class="row px-7 mt-4">\
                            <div class="row bg-light py-2 w-100 justify-content-center">\
                                <h4 class="text-reguler">\
                                Periksa Koneksi Anda. \
                                <a href="/student/12344123/subjects" class="btn btn-primary btn-lg">\
                                Tampilkan Daftar Mapel </a></h4>\
                            </div>\
                        </div>';
            $('#accordion-pts').html(view);
        });
    }
    subjectIndex();

    function Onboarding(id, title){
        localStorage.setItem('detail_title', title);
        window.location.href = `/student/subjects/12342113`;
    }
</script>
@endpush
