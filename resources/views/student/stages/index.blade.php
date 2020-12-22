@extends('layout.index')

@section('title', 'Daftar Babak - ' . $game['title'])

@section('content')
<div class="container" id="game-id" data-game="{{ $game['uri'] }}">
        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('student/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('student/games') }}">Beranda</a>
            <span class="breadcrumb-item active">{{ $game['short'] }}</span>
        </nav>
        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{ $game['title'] }}</h2>
        </div>

        <!-- List of Stages (Student)-->
        <div class="list-group list-group-student">
        </div>


    </div>
@endsection

@push('script')

<script>

    const game = $('#game-id').data('game');

    loadStages();

    function loadStages() {
        const url = "{!! URL::to('student/games/api/' . $game['uri'] . '/stages') !!}";
        const loading = `
            <div class="px-4">
                <div class="row align-items-center mt-2 alert alert-primary">
                    <div class="spinner spinner-border spinner-border-sm text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <h6 class="ml-2">Mengambil data babak.</h6>
                </div>
            </div>`;
        const retry = `
            <div>
                <p>Data gagal di dapatkan.</p>
                <button id="retry-button" onClick="loadStages()" class="btn btn-primary">Coba Lagi</button>
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
                if (response.data.length > 0) {
                    for (let i = 0; i < response.data.length; i++) {
                        const element = response.data[i];
                            html += getHtml(element)
                    }
                } else {
                    html = '<h5 class="text-center">Tidak ada data</h5>';
                }

                $('.list-group-student').html(html);
            },
            error: function() {
                $('.list-group-student').html(retry);
            }
        });
    }

    function getHtml(data) {
        const url = "{!! URL::to('student/games/' . $game['uri'] . '/stages/') !!}";
        const html = `
        <div class="list-group-item">
            <a href="${ url }/${ data.id }/rounds">
                <div class="d-flex">
                    <div>
                        <i class="kejar-right"></i>
                        Babak ${ data.order } :
                    </div>
                    <div>
                        ${ data.title }
                    </div>
                </div>
            </a>
            <!-- <div class="hover-only"> -->
                <div class="stage-order-buttons done-status">
                    <!-- <button class="btn-icon">
                        <i class="kejar-sudah-dikerjakan"></i>
                    </button> -->
                </div>
            <!-- </div> -->
        </div>`;

        return html;
    }


</script>

@endpush