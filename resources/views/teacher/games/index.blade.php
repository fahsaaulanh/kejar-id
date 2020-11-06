@extends('layout.index')

@section('title', 'Permainan')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
@endsection

@if(session('user.PasswordMustBeChanged') === true || session('user.changePhotoOnBoarding') === true)
@section('header')
@endsection
@endif

@section('content')
@if(session('user.PasswordMustBeChanged') === true)
<!-- form ganti password -->
<div class="bg-lego">
    <div class="container-center">
        <form class="card-384" action="{{ url('/' . strtolower(session('user.role') . '/change-password')) }}" method="post">
            @csrf
            @method('PATCH')
            <h3>Ganti Password
                <a href="{{ url('/teacher/skip-change-info?type=password') }}" class="close">
                    <i class="kejar kejar-close"></i>
                </a>
            </h3>

            <div>
                <p><strong>Password belum diganti, ganti dulu agar lebih aman.</strong></p>
                <p>Password harus terdiri dari minimal 6 karakter, kombinasi huruf dan angka.</p>
                <div class="form-group">
                    <label for="passwordBaru">Password Baru</label>
                    <div class="input-group input-group-password @error('password_baru') is-invalid @enderror">
                        <input type="password" name="password_baru" id="passwordBaru" class="form-control" placeholder="Buat password" value="{{ old('password_baru') }}">
                        <div class="input-group-append">
                            <button tabindex="-1" class="btn btn-outline-light" type="button"><i class="kejar-hide-password"></i></button>
                        </div>
                        @if($errors->has('password_baru'))
                        <div class="invalid-feedback text-right">
                            {{ $errors->first('password_baru') }}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="konfirmasiPassword">Konfirmasi Password</label>
                    <div class="input-group input-group-password @error('konfirmasi_password') is-invalid @enderror">
                        <input type="password" name="konfirmasi_password" id="konfirmasiPassword" class="form-control" placeholder="Konfirmasi password baru" value="{{ old('konfirmasi_password') }}">
                        <div class="input-group-append">
                            <button tabindex="-1" class="btn btn-outline-light" type="button"><i class="kejar-hide-password"></i></button>
                        </div>
                        @if($errors->has('konfirmasi_password'))
                        <div class="invalid-feedback text-right">
                            {{ $errors->first('konfirmasi_password') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Simpan</button>
        </form>
    </div>
</div>
<div class="bg-lego-mobile"></div>
@elseif(session('user.changePhotoOnBoarding') === true)
<!-- form ganti foto -->
<div class="bg-lego">
    <div class="container-center">
        <form class="card-384" action="{{ url('/' . strtolower(session('user.role') . '/change-profile')) }}" method="post" name="change_profile_onboarding">
            @csrf
            @method('PATCH')
            <h3>Pasang Foto Profil <a href="{{ url('/teacher/skip-change-info?type=photo') }}" class="close" data-dismiss="modal" aria-label="Close">
                <i class="kejar kejar-close"></i>
            </a></h3>

            <div class="mt-5">
                <p>Pasang foto profil untuk memudahkan siswa dan sejawat guru mengenali profil Bapak/Ibu.</p>
                <div class="form-group">
                    <input type="file" id="drop-photo" name="select_photo_onboarding" class="dropify" data-allowed-file-extensions="jpg jpeg png"/>
                    <input type="hidden" name="photo_onboarding">
                </div>
            </div>
            <a href="{{ url('/teacher/skip-change-info?type=photo') }}" class="text-muted text-decoration-none float-right mt-5">Lewati ></a>
        </form>
    </div>
</div>
<div class="bg-lego-mobile"></div>
@else
<div class="bg-blue-tp">
    <div class="container-fluid">
        <div class="row dashboard">
            @if(in_array(session('user.userable.school_id'),$wikramaId))
                <div class="col-12">
                    <div class="content-header">
                        <h1 class="content-title">Pilih penilaian...</h1>
                    </div>
                    <div class="content-body">
                        @forelse($miniAssesmentGroup as $key => $v)
                            <div class="card-deck pl-4 pr-4 pb-4">
                                <div class="list-card-menu-item col-12" data-id="#">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#ma-view-as" onclick="selectMA('{{$key}}')">
                                        <h3><i class="kejar-penilaian" ></i> {{$v}}</h3>
                                    </a>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="content-header">
                    <h1 class="content-title">Pilih permainan...</h1>
                </div>
                <div class="content-body">
                    <div class="card-deck">
                        <a href="{{ $reportAccess ? url('/teacher/games/obr/class') : '#' }}" class="card">
                            <img src="{{ asset('assets/images/home/obr.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Operasi Bilangan Riil</h5>
                                <p class="card-text">Berhitung lebih cepat dan tepat agar belajar Matematika mudah dan lancar.</p>
                            </div>
                        </a>
                        <a href="{{ $reportAccess ? url('/teacher/games/katabaku/class') : '#' }}" class="card">
                            <img src="{{ asset('assets/images/home/kata-baku.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Kata Baku</h5>
                                <p class="card-text">Menulis lebih profesional dengan Bahasa Indonesia yang baik dan benar.</p>
                            </div>
                        </a>
                        <a href="{{ $reportAccess ? url('/teacher/games/vocabulary/class') : '#' }}" class="card">
                            <img src="{{ asset('assets/images/home/vocab.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Vocabulary</h5>
                                <p class="card-text">Lebih percaya diri menulis dan berbicara dalam Bahasa Inggris karena kosakata yang kaya.</p>
                            </div>
                        </a>
                    </div>
                    @env(['staging', 'local'])
                    <div class="card-deck">
                        <a href="{{ url('/teacher/games/toeicwords/class') }}" class="card">
                            <img src="{{ asset('assets/images/home/toeic-words.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">TOEIC Words</h5>
                                <p class="card-text">Kuasi 4000 kosakata yang sering muncul pada TOEIC.</p>
                            </div>
                        </a>
                        <a href="{{ url('/teacher/games/menulisefektif/class') }}" class="card">
                            <img src="{{ asset('assets/images/home/menulis-efektif.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Menulis Efektif</h5>
                                <p class="card-text">Menulis kata yang tepat agar menjadi kalimat yang efektif.</p>
                            </div>
                        </a>
                    </div>
                    @endenv
                </div>
            </div>
        </div>
    </div>
</div>
@include('teacher.mini_assessments._modal_view_as')
@endif
@endsection

@push('script')
<script src="{{ asset('assets/plugins/dropify/dist/js/dropify.js')}}"></script>
<script type="text/javascript">
    $('.dropify').dropify({
        messages: {
            'default': 'Pilih Foto',
            'replace': 'Ubah Foto',
            'remove':  'Hapus Foto',
            'error':   'Error'
        }
    });

    $('input[name=select_photo_onboarding]').change(function(){
        readURL(this);
    });

    function selectMA(val) {
        var urlSubjectTeachers = "{!! URL::to('/teacher/subject-teachers/mini-assessment') !!}"+"/"+val;
        var urlStudentCounselor = "{!! URL::to('/teacher/student-counselor/mini-assessment') !!}"+"/"+val+"/list";
        $("#select-ma-subject-teachers").attr("href", urlSubjectTeachers);
        $("#select-ma-student-counselor").attr("href", urlStudentCounselor);
    }
</script>

@if(session('user.PasswordMustBeChanged') === true || session('user.changePhotoOnBoarding') === true)
    <script>
        $('#updatePassword').remove();
    </script>
@endif
@endpush
