@extends('layout.index')

@section('title', 'Daftar Ronde - ' . $stage['title'])

@section('content')

<div class="container">
    <!-- Link Back -->
    <a class="btn-back" href="{{ url('student/games/' . $game['uri'] . '/stages') }}">
        <i class="kejar-back"></i>Kembali
    </a>
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('student/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('student/games/' . $game['uri'] . '/stages') }}">{{ $game['short'] }}</a>
        <span class="breadcrumb-item active">Babak {{ $stage['order'] }}</span>
    </nav>
    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">{{ $stage['title'] }}</h2>
    </div>

    <!-- List of Stages (Student)-->

    <p class="description">{{ $stage['description'] }}</p>

    <div class="list-group list-group-student">

    </div>
</div>

@endsection

@push('script')
<script>
    loadData();

    function loadData() {
        const url = "{!! URL::to('student/games/api/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds') !!}";
        const loading = `
            <div class="px-4">
                <div class="row align-items-center mt-2 alert alert-primary">
                    <div class="spinner spinner-border spinner-border-sm text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <h6 class="ml-2">Mengambil data ronde.</h6>
                </div>
            </div>`;
        const retry = `
            <div>
                <p>Data gagal di dapatkan.</p>
                <button id="retry-button" onClick="loadData()" class="btn btn-primary">Coba Lagi</button>
            </div>`;

        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            beforeSend: function() {
                $('.list-group-student').html(loading);
            },
            success: function (response) {
                let html = '';
                let linkTo = "{!! URL::to('student/games/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds') !!}";
                if (response.data.length > 0) {
                    response.data.forEach((round, index) => {
                        html += `
                            <div class="list-group-item">
                                <a href="${ linkTo }/${ round.id }/onboardings">
                                    <div class="d-flex">
                                        <div>
                                            <i class="kejar-round"></i>
                                            <span>Ronde ${ round.order } : </span>
                                        </div>
                                        <div>
                                            <span class="question-round"> ${ round.title }</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="star-item ${ round.score === null ? 'd-none' : '' }">
                                    <span class="star-icon active">
                                        <i class="kejar-arsip-asesmen${ round.score > 50 ? '-bold' : '' }"></i>
                                    </span>
                                    <span class="star-icon active">
                                        <i class="kejar-arsip-asesmen${ round.score > 75 ? '-bold' : '' }"></i>
                                    </span>
                                    <span class="star-icon active">
                                        <i class="kejar-arsip-asesmen${ round.score == 100 ? '-bold' : '' }"></i>
                                    </span>
                                </div>
                                <div class="stage-order-buttons">
                                    <div class="play-button">
                                        <a href="${ linkTo }/${ round.id }/onboardings" class="btn-next">
                                            Main <i class="kejar-play"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>`;
                    });
                } else {
                    html = '<h5 class="text-center">Tidak ada data</h5>';
                }

                $('.list-group-student').html(html);
            },
            error: function(err) {
                $('.list-group-student').html(retry);
            }
        });
    }
</script>
@endpush