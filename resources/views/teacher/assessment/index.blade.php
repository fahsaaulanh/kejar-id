@extends('layout.index')

@section('title', $assessmentGroup)

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
            <span class="breadcrumb-item active">{{$assessmentGroup}}</span>
            <span class="breadcrumb-item active">{{$subject['name']}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">Kelas {{$grade}}</h2>
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

        @if(count($miniAssessments) == 0)
            <button class="btn-upload" data-toggle="modal" data-target="#add-ma">
                <i class="kejar-upload"></i>Unggah Naskah
            </button>
        @else
            <button class="btn btn-primary font-15">
                <i class="kejar-siswa"></i>Tugaskan Siswa
            </button>
        @endif

        <ul class="nav nav-tabs mt-8" id="myTab" role="tablist">
            <li class="nav-item w-50 text-center" role="presentation">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Nilai</a>
            </li>
            <li class="nav-item w-50 text-center" role="presentation">
                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Soal</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row mt-8">
                    <div class="col"><h3>Pengaturan</h3></div>
                    <div class="col col-sm-2">
                        <button class="btn bg-white btn-revise" data-toggle="modal" data-target="#setting_pack"><i class="kejar-setting"></i>Ubah</button>
                    </div>
                </div>
                <div class="row mb-4">
                    @if(isset($miniAssessments[0]['pdf_password']) == true)
                        <div class="col">
                            <h5>Token/Password PDF</h5>
                            <h5 class="text-reguler">{{($miniAssessments[0]['pdf_password'] == null ? '-' : $miniAssessments[0]['pdf_password'])}}</h5>
                        </div>
                    @endif
                    <div class="col">
                        <h5>Durasi</h5>
                        <h5 class="text-reguler">{{($miniAssessments[0]['duration'] == null ? '-' : $miniAssessments[0]['duration'].' menit')}}</h5>
                    </div>
                </div>
                <div class="row mb-8">
                    @if(isset($miniAssessments[0]['total_questions']) == true)
                        <div class="col">
                            <h5>Banyaknya Soal</h5>
                            <h5 class="text-reguler">{{($miniAssessments[0]['total_questions'] == null ? '-' : $miniAssessments[0]['total_questions'].' soal')}}</h5>
                        </div>
                    @endif
                    @if(isset($miniAssessments[0]['choices_number']) == true)
                        <div class="col">
                            <h5>Jumlah Jawaban</h5>
                            <h5 class="text-reguler">{{($miniAssessments[0]['choices_number'] == null ? '-' : $miniAssessments[0]['choices_number'])}}</h5>
                        </div>
                    @endif
                </div>
                <h3 class="mb-4">Paket<span class="font-15 text-reguler">(total: {{$miniAssessmentsMeta['total']}})</span></h3>
                @for($i=0; $i < count($miniAssessments); $i++)
                    <div class="w-100 bg-grey-15 mb-4 px-4 py-3">
                        <a class="text-black-1 ">{{$miniAssessments[$i]['title']}}</a>
                    </div>
                @endfor
                <button class="btn-upload font-15" data-toggle="modal" data-target="#add-ma">
                    <i class="kejar-add"></i>Tambah Paket
                </button>
            </div>
        </div>


    </div>
@include('teacher/assessment.mini._upload_pdf')
@include('teacher/assessment.mini._setting_package')
@include('teacher/assessment.mini._info_token')

@endsection


@push('script')
<script>
    function showLoadingCreate(){
        $("#LoadingCreate").show();
    }

    $('#upload_pdf_file').on('change', (e) => {
        if(e.currentTarget.files[0].size <= 1000000){
            $('#upload_pdf_name').val(e.currentTarget.files[0].name);
            if($('#file_alert').hasClass('show')){
                $('#file_alert').removeClass('show').addClass('hide');
            }
        }else{
            $('#file_alert').removeClass('hide').addClass('show');
            setInterval(() => {
                $('#file_alert').removeClass('show').addClass('hide')
            }, 4000)
        }
    })
</script>
@endpush
