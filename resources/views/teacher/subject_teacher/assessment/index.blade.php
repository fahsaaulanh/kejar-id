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
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Penugasan dan Nilai</a>
            </li>
            <li class="nav-item w-50 text-center" role="presentation">
                <a class="nav-link active" id="packgae-tab" data-toggle="tab" href="#packgae" role="tab" aria-controls="packgae" aria-selected="false">Soal</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
            <div class="tab-pane fade show active" id="packgae" role="tabpanel" aria-labelledby="packgae-tab">
                <div class="row mt-8">
                    <div class="col"><h3>Pengaturan</h3></div>
                    <div class="col col-sm-2">
                    @if($type === 'assessment')
                        <button class="btn bg-white btn-revise" data-toggle="modal" data-target="#duration"><i class="kejar-setting"></i>Ubah</button>
                    @else
                        <button class="btn bg-white btn-revise" data-toggle="modal" data-target="#setting_pack"><i class="kejar-setting"></i>Ubah</button>
                    @endif
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

                @if($type === 'assessment')
                    <h3 class="mb-4">Daftar Soal</h3>
                    <button class="btn-upload font-15" data-toggle="modal" data-target="#create-pilihan-ganda">
                        <i class="kejar-add"></i>Tambah Paket
                    </button>
                    @for($i=1; $i <= 10; $i++)
                    <div class="pb-4">
                        <div class="w-100 bg-green px-4 py-3">
                            <div class="row justify-content-between px-4">
                                <h5>SOAL {{ $i }}</h5>
                                <div class="justify-content-end">
                                    <a href="#" id="nav-{{$i}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="kejar-add"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-{{$i}}">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-pilihan-ganda"><i class="kejar-edit"></i> Edit Soal</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_question"><i class="kejar-add"></i> Hapus Soal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 border-grey-13 px-4 py-3">
                            <h5 class="pb-8">Jawablah pertanyaan berikut!</h5>
                            <div class="pb-8">
                                Pada suatu hari, hiduplah dua orang bersaudara bernama Ana dan Elsa. 
                                Mereka berdua tinggal pada sebuah istana di negeri yang bernama Arandelle. 
                                Sejak kecil, Ana dan Elsa senang bermain bersama. 
                                Permainan favorit mereka adalah membuat manusia salju. Mereka juga senang bercerita. 
                                Mereka saling menyayangi. Jawaban yang tepat adalah ...
                            </div>
                            <div class="pb-8">
                                <div class="radio-group">
                                    <i class="kejar-radio-button"></i>
                                    Ibu dan ayah pergi ke Taman Safari.
                                </div>
                                <div class="radio-group">
                                    <i class="kejar-belum-dikerjakan"></i>
                                    Ibu dan ayah pergi ke Taman Safari.
                                </div>
                                <div class="radio-group">
                                    <i class="kejar-belum-dikerjakan"></i>
                                    Ibu dan ayah pergi ke Taman Safari.
                                </div>
                                <div class="radio-group">
                                    <i class="kejar-belum-dikerjakan"></i>
                                    Ibu dan ayah pergi ke Taman Safari.
                                </div>
                                <div class="radio-group">
                                    <i class="kejar-belum-dikerjakan"></i>
                                    Ibu dan ayah pergi ke Taman Safari.
                                </div>
                            </div>
                            <h5 class="pb-4">Pembahasan:</h5>
                            <div>
                                <div>- Huruf kapital digunakan pada awal kalimat</div>
                                <div>- Huruf kapital digunakan pada awal kalimat</div>
                                <div>- Huruf kapital digunakan pada awal kalimat</div>
                            </div>
                        </div>
                    </div>
                    @endfor
                @else
                    <h3 class="mb-4">Paket<span class="font-15 text-reguler">(total: {{$miniAssessmentsMeta['total']}})</span></h3>
                    @for($i=0; $i < count($miniAssessments); $i++)
                        <div class="w-100 bg-grey-15 mb-4 px-4 py-3">
                            <a class="text-black-1 ">{{$miniAssessments[$i]['title']}}</a>
                        </div>
                    @endfor
                    <button class="btn-upload font-15" data-toggle="modal" data-target="#add-ma">
                        <i class="kejar-add"></i>Tambah Paket
                    </button>
                @endif
            </div>
        </div>
    </div>
@include('teacher.subject_teacher.assessment.mini._upload_pdf')
@include('teacher.subject_teacher.assessment.mini._setting_package')
@include('teacher.subject_teacher.assessment.mini._info_token')
@include('teacher.subject_teacher.assessment.regular.create._pilihan_ganda')
@include('teacher.subject_teacher.assessment.regular.update._pilihan_ganda')
@include('teacher.subject_teacher.assessment.regular._delete_question')
@include('teacher.subject_teacher.assessment.regular.update._duration')


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
