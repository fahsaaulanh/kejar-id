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
            <h1 id="title" class="mb-08rem"> Pilih mata pelajaran</h1>
        </div>
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
    window.onload = function() {
        subjectIndex();
    };

    const title = localStorage.getItem('pts_title') || '';
    $('#breadcrumb-1').html(title);
    window.document.title = `${title}`;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function subjectIndex()
    {
        const url = "{!! URL::to('/student/me/schedules/assessments') !!}";
        let data = {
            assessment_group_id: `{{$assessmentGroupId}}`,
        };

        return $.ajax({
            url,
            type: 'POST',
            data: data,
            dataType: 'json',
            crossDomain: true,
            beforeSend: function() {
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
            },
            error: function(error) {
                var view = `<div class="row px-7 mt-4">\
                            <div class="row bg-light py-2 w-100 justify-content-center">\
                                <h4 class="text-reguler">\
                                Periksa Koneksi Anda. \
                                <a href="/student/${data.assessment_group_id}/subjects" class="btn btn-primary btn-lg">\
                                Tampilkan Daftar Mapel </a></h4>\
                            </div>\
                        </div>`;
                $('#accordion-pts').html(view);
            },
            success: function(response) {
                $('#accordion-pts').html(response);
            }
        });
    }

    function goOnboarding(element)
    {
        schedule_id = $(element).attr('data-id');
        assessment_group_id = '{{$assessmentGroupId}}';

        window.location.href = `/student/${assessment_group_id}/subjects/${schedule_id}/onboarding`;
    }

</script>
@endpush
