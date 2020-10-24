@extends('layout.index')

@section('title', 'PTS')

@section('content')
    <div class="container">
        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('student/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('student/games') }}">Beranda</a>
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
@endsection

@push('script')
<script>

    const title = localStorage.getItem('pts_title') || '';
    $('#breadcrumb-1').html(title);
    window.document.title = `${title}`;

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

        const url = "{!! URL::to('/student/mini_assessment/get-subject') !!}";
        let data  = new Object();

        data = {
            page: page,
            paginationFunction: 'subjectIndex',
            // subject_name: $("#subject-name").val(),
            mini_assessment: localStorage.getItem('pts_title')
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
            console.error(error);
        });
    }
    subjectIndex();

    function goExam(id, title){
        localStorage.setItem('detail_title', title);
        window.location.href = `/student/mini_assessment/${id}`;
    }
</script>
@endpush
