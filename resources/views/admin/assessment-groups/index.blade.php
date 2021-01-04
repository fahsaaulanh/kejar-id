@extends('layout.index')

@section('title', 'Kelompok Penilaian')

@section('content')
<div class="container">

    <!-- Link Back -->
    <a class ="btn-back" href="{{ url('/admin/games') }}">
        <i class="kejar-back"></i>Kembali
    </a>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/admin/games') }}">Beranda</a>
        <span class="breadcrumb-item active">{{$school['name']}}</span>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">Penilaian TP {{date('Y')}}-{{date('Y') + 1}}</h2>
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

    <button class="btn-upload" id="assess-tambah">
        <i class="kejar-add"></i>Tambah Kelompok Penilaian
    </button>

    <!-- List of Assessment Group-->
    <div class="list-group" data-url="#" data-token="{{ csrf_token() }}">
        @forelse($assessmentGroups as $key => $v)
            <a class="list-group-item text-dark" href="{{ URL('admin/curriculum/schools/'.$school['id'].'/assessment-groups/'.$v['id'].'/subjects') }}" class="col-12">
                <div>
                    <i class="kejar-paket-penilaian"></i>
                    {{$v['title']}}
                </div>
            </a>
        @empty
            <h5 class="text-center">Tidak ada data</h5>
        @endforelse
    </div>
</div>
@include('admin.assessment-groups.modals._add_assessment')
@endsection

@push('script')
<script type="text/javascript">
    $('#assess-tambah').on('click', function() {
        $('#modal-addAssessment').modal('show');
    });

    $("#simpan-addAssessment").on('click', function() {
        createAssessmentGroup();
    });

    function createAssessmentGroup() {
        const url = "{!! URL::to('/admin/curriculum/api/assessment-groups/create') !!}";
        const title = $('#title-addAssessment').val();
        const schoolId = "{{$school['id']}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const loading = `<div class="spinner spinner-border text-white" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>`

        $.ajax({
            method: 'post',
            data: {
                title,
                schoolId,
            },
            dataType: 'json',
            url: url,
            beforeSend: function() {
                $("#simpan-addAssessment").html(loading);
                $("#simpan-addAssessment").attr('disabled', true);
            },
            success: function (response) {
                if(response.status == 201){
                    $("#simpan-addAssessment").html("Simpan");
                    $("#simpan-addAssessment").removeAttr('disabled');
                    $('#title-addAssessment').val('');
                    $('#modal-addAssessment').modal('hide');
                    window.location.reload();
                }
            },
            error: function (error) {
                $("#simpan-addAssessment").html("Coba Lagi");
                $("#simpan-addAssessment").removeAttr('disabled');
                $("#simpan-addAssessment").on('click', function () {
                    createAssessmentGroup();
                });
            }
        });
    }
</script>
@endpush
