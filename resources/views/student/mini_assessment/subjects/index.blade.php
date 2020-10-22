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

        <div class="accordion" id="accordion-pts">
            <!-- Empty -->
        </div>
    </div>
@endsection

@push('script')
<script>
    var school_id = "3da67e44-ca12-4ae8-b784-f066ea605887";
    if ("{{ env('APP_ENV') }}" === 'staging' || "{{ env('APP_ENV') }}" === 'local') {
        var school_id = "73ceaf53-a9d8-4777-92fe-39cb55b6fe3b";
    }
    const url = "{!! URL::to('/student/mini_assessment/service/subjects') !!}";
    fetchSubjects(url, { school_id });
</script>
@endpush

@prepend('script')
<script>
    // On Load
    let dataMA = [];
    const title = localStorage.getItem('pts_title') || '';
    $('#breadcrumb-1').html(title);
    window.document.title = `${title}`;
    //

    // Function
    function renderLoading() {
        return `
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
        `;
    }

    function renderSubjects(data = []) {

        if (data.length < 1) {
            return `
                <div class="row px-7 mt-4">
                    <div class="row bg-light py-2 w-100 justify-content-center">
                        <h4 class="text-reguler">
                        <a href="/student/mini_assessment" class="btn btn-primary btn-lg"> Tampilkan Daftar Mapel </a></h4>
                    </div>
                </div>
            `;
        }

        return data.map((d, index) => {
            const start = moment(d.start_fulldate).valueOf();
            const end = moment(d.expiry_fulldate).valueOf();
            const now = moment("{{ $now }}").valueOf();

            const isExpired = (now < start || now > end);
            const done = d.tasks.length > 0 ? true : false;

            return `
                <div class="row mt-4">
                    <div
                        class="btn-accordion${isExpired || done ? '-disabled' : ''}"
                        ${isExpired || done ? '' : 'role="button"'}
                        id="subject-${index}"
                        onclick="onClickSubject(${index},${isExpired || done})"
                    >
                        <div class="row">
                            <div class="col-md-6" id="mapel">
                                <h4 class="${isExpired || done ? 'text-reguler' : '' }">${d.subject}</h4>
                                ${done ? '' : '<h5 class="text-reguler">'+d.start_date+'</h5>'}
                                ${done ? '' : '<h5 class="text-reguler">'+d.start_time+' - '+d.expiry_time+'</h5>'}
                            </div>
                            <div class="col-md-6 mt-2 mt-md-0 mt-lg-0 align-items-end">
                                <div class="row justify-content-start justify-content-md-end justify-content-lg-end">
                                    <div class="col-auto">
                                        <span class="badge-${done ? 'done' : 'undone'} label">
                                            ${done ? 'SUDAH DIKERJAKAN' : 'BELUM DIKERJAKAN'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `
        });
    }

    function onClickSubject(index, expired = false) {
        if (expired) {
            return;
        }

        if (typeof window !== 'undefined') {
            const start = new Date(dataMA[index].start_fulldate).getTime();
            const end = new Date(dataMA[index].expiry_fulldate).getTime();
            const now = new Date().getTime();

            if (now < start && now > end) {
                return;
            }

            localStorage.setItem('detail_title', dataMA[index].subject);
            window.location.href = `/student/mini_assessment/${dataMA[index].subject_id}`
        }
    }
    //

    // API Call Function
    function fetchSubjects(url, payload) {
        $.ajax({
            url,
            type: 'GET',
            data: payload,
            dataType: 'json',
            crossDomain: true,
            beforeSend: function() {
                $('#accordion-pts').html(renderLoading());
            },
            error: function(error) {
                $('#accordion-pts').html(renderSubjects([]))
            },
            success: function(response){
                if (response.status === 200) {
                    dataMA = response.data;
                    $('#accordion-pts').html(renderSubjects(response.data))
                    return;
                }
                $('#accordion-pts').html(renderSubjects([]))
            }
        });
    }
    //
</script>
@endprepend
