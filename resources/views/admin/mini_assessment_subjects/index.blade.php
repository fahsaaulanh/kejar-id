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
            <span class="breadcrumb-item active">{{$miniAssessmentGroup}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{$miniAssessmentGroup}}</h2>
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

        <form disabled>
            <div class="row mb-5">
                <div class="col-10">
                    <div class="input-group">
                        <span class="input-group-append">
                            <h2 class="border-right-0 border pt-1 pl-1">
                                <i class="kejar-search text-muted"></i>
                            </h2>
                        </span>
                        <input class="form-control py-2 border-left-0 border" id="code-tracking" type="search">
                    </div>
                </div>
                <div class="col-2">
                    <span class="btn btn-revise btn-block bg-white" onclick="viewTracking()">
                        <span>Cari</span>
                    </span>
                </div>
            </div>
        </form>

        <!-- List of Stages (Admin)-->
        <div class="list-group" data-url="#" data-token="{{ csrf_token() }}">
            @forelse($subjects as $key => $v)
                <div class="list-group-item" data-toggle="collapse" data-target="#collapse-{{ $v['id']}}" aria-expanded="false" aria-controls="collapse-{{ $v['id']}}">
                    <a href="javascript:void(0)" class="col-12">
                        <i class="kejar-mapel" data-toggle="collapse" data-target="#collapse-{{ $v['id']}}" aria-expanded="false" aria-controls="collapse-{{ $v['id']}}"></i>
                        {{$v['name']}}
                    </a>
                </div>
                <div class="collapse" id="collapse-{{ $v['id']}}" style="margin-top: -16px;">
                    @for($i=0; $i < 3; $i++)
                        <div class="list-group" data-url="#" data-token="{{ csrf_token() }}">
                            <div class="list-group-item-dropdown">
                                <a href="{{ URL('admin/mini-assessment/'.$miniAssessmentGroupValue.'/subject/'.$v['id'].'/1'.$i) }}" class="col-12">
                                    <span class="ml-5">Kelas 1{{$i}}</span>
                                    <i class="kejar-right float-right"></i>
                                </a>
                            </div>
                        </div>
                    @endfor()
                </div>
            @empty
                <h5 class="text-center">Tidak ada data</h5>
            @endforelse
        </div>

        @if($subjectMeta && ($subjectMeta['total'] > 20))
            <!-- Pagination -->
            <nav class="navigation mt-5">
                <div>
                    <span class="pagination-detail">{{ $subjectMeta['to'] ?? 0 }} dari {{ $subjectMeta['total'] }} soal</span>
                </div>
                <ul class="pagination">
                    <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
                    </li>
                    @for($i=1; $i <= $subjectMeta['last_page']; $i++)
                    <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                    </li>
                    @endfor
                    <li class="page-item {{ ((request()->page ?? 1) + 1) > $subjectMeta['last_page'] ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
                    </li>
                </ul>
            </nav>
        @endif()

    </div>

<div class="modal fade bd-example-modal-md" id="view-ma-tracking">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kode Paket<br>
                    <small id="tracking-title"></small>
                </h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="ma-tracking" style="display:none">
                    <div id="loading-ma-tracking">
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
                    <div id="tracking-content"></div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <div class="text-right col-md-12">
                    <button class="btn btn-primary pull-right" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
<script src="{{ mix('/js/admin/stage/script.js') }}"></script>
<script>
    function viewTracking(){
        $("#loading-ma-tracking").show();
        $("#tracking-content").empty();
        $("#tracking-title").empty();
        $("#ma-tracking").show();

        $("#view-ma-tracking").modal('show');

        const url = "{!! URL::to('/admin/mini-assessment/tracking-code') !!}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var data = {
            code : $("#code-tracking").val(),
            mini_assessment : "{{$miniAssessmentGroupValue}}"
        };

        $.ajax({
            method: 'post',
            data: data,
            url: url,
            success: function (response) {
                if(response){
                    $("#tracking-content").html(response.view);
                    $("#tracking-title").html(response.code);
                }else{

                    var alert = '<h2>Data tidak ditemukan!</h2>';

                    $("#tracking-content").html(alert);
                }
                $("#loading-ma-tracking").hide();
                $("#ma-tracking").show();
            }
        });
    }
</script>
@endpush
