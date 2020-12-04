@extends('layout.index')

@section('title', 'Permainan')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dist/css/dropify.css')}}">
@endsection

@section('content')

    @if(Session::get('user.PasswordMustBeChanged') == true)
        <!-- form ganti password -->
        <div class="bg-lego">
            <div class="container-center">
                <form class="card-384" action="{{ url('/' . strtolower(session('user.role') . '/change-password')) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <h3>Ganti Password
                        <a href="{{ url('/student/skip-change-info?type=password') }}" class="close" data-dismiss="modal" aria-label="Close">
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
                    <h3>Pasang Foto Profil <a href="{{ url('/student/skip-change-info?type=photo') }}" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </a></h3>

                    <div class="mt-5">
                        <p>Jadikan profilmu lebih keren dengan memasang foto. Gunakan foto yang baik, guru-gurumu akan melihat foto profil ini.</p>
                        <div class="form-group">
                            <input type="file" id="drop-photo" name="select_photo_onboarding" class="dropify" data-allowed-file-extensions="jpg jpeg png"/>
                            <input type="hidden" name="photo_onboarding">
                        </div>
                    </div>
                    <a href="{{ url('/student/skip-change-info?type=photo') }}" class="text-muted text-decoration-none float-right mt-5">Lewati ></a>
                </form>
            </div>
        </div>
        <div class="bg-lego-mobile"></div>
    @else
        <div class="bg-blue-tp">
            <div class="container-fluid">
                <div class="row dashboard">
                    <div class="col-12">
                        @php
                            $loweredSchoolName = strtolower(session('user.userable.school_name'));
                            $isWikrama = strpos($loweredSchoolName, 'wikrama') !== false;
                        @endphp
                        <div class="content-header">
                            <h1 class="content-title">Penilaian TP {{ $academicYear }}</h1>
                        </div>
                        <div class="content-body mb-144">
                            <div id="pts">

                            </div>
                        </div>
                        <div class="content-header">
                            <h1 class="content-title">Latihan AKM</h1>
                        </div>
                        <div class="content-body">
                            <div class="card-deck justify-content-start">
                                <a href="{{ url('/student/games/soalcerita/stages') }}" class="card">
                                    <img src="{{ asset('assets/images/home/soal-cerita.jpg') }}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Soal Cerita</h5>
                                        <p class="card-text">Lebih cerdas menyelesaikan permasalahan di kehidupan sehari-hari dengan kemampuan matematika.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="content-header">
                            <h1 class="content-title">Matrikulasi</h1>
                        </div>
                        <div class="content-body">
                            <div class="card-deck">
                                <a href="{{ url('student/games/obr/stages') }}" class="card">
                                    <img src="{{ asset('assets/images/home/obr.jpg') }}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Operasi Bilangan Riil</h5>
                                        <p class="card-text">Berhitung lebih cepat dan tepat agar belajar Matematika mudah dan lancar.</p>
                                    </div>
                                </a>
                                <a href="{{ url('student/games/katabaku/stages') }}" class="card">
                                    <img src="{{ asset('assets/images/home/kata-baku.jpg') }}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Kata Baku</h5>
                                        <p class="card-text">Menulis lebih profesional dengan Bahasa Indonesia yang baik dan benar.</p>
                                    </div>
                                </a>
                                <a href="{{ url('student/games/vocabulary/stages') }}" class="card">
                                    <img src="{{ asset('assets/images/home/vocab.jpg') }}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Vocabulary</h5>
                                        <p class="card-text">Lebih percaya diri menulis dan berbicara dalam Bahasa Inggris karena kosakata yang kaya.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="card-deck justify-content-start">
                                <a href="{{ url('/student/games/toeicwords/stages') }}" class="card">
                                    <img src="{{ asset('assets/images/home/toeic-words.jpg') }}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">TOEIC Words</h5>
                                        <p class="card-text">Kuasi 4000 kosakata yang sering muncul pada TOEIC.</p>
                                    </div>
                                </a>
                                <a href="{{ url('/student/games/menulisefektif/stages') }}" class="card">
                                    <img src="{{ asset('assets/images/home/menulis-efektif.jpg') }}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Menulis Efektif</h5>
                                        <p class="card-text">Menulis kata yang tepat agar menjadi kalimat yang efektif.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@include('student.games._modal_pts')
@endsection

@push('script')
<script src="{{ asset('assets/plugins/dropify/dist/js/dropify.js')}}"></script>
<script src="{{ mix('/js/student/games/script.js') }}"></script>
<script type="text/javascript">
let dataPts = [];
getAssessmentGroups();

$('.dropify').dropify({
    messages: {
        'default': 'Pilih Foto',
        'replace': 'Ubah Foto',
        'remove':  'Hapus Foto',
        'error':   'Error'
    }
});

function changeDrop() {
    $("#updateProfile").modal('toggle');


    setInterval(function(){
        var base64Img = $(".dropify-render").html()
                                        .toString()
                                        .replace('<img src="', '')
                                        .replace('">', '');

        $('#profile-pict-crop').attr('src',base64Img);

        console.log(base64Img);

        $('.profile-pict-crop').rcrop({
            minSize : [200,200],
            maxSize : [2000,2000],
            preserveAspectRatio : true,
            grid : true
        });
    }, 200);
}

function getAssessmentGroups() {
    const url = "{!! URL::to('/student/api/assessment-groups') !!}";
    const loading = `
        <div class="px-4">
            <div class="row align-items-center mt-2 alert alert-primary">
                <div class="spinner spinner-border spinner-border-sm text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <h6 class="ml-2">Mengambil data penilaian.</h6>
            </div>
        </div>`;


    const empty = `
        <div class="alert alert-primary mt-2">
            <h6>Tidak ada data penilaian.</h6>
        </div>`

    const retryButton = `
        <div>
            <p>Data gagal di dapatkan.</p>
            <button id="retry-button" class="btn btn-primary">Coba Lagi</button>
        </div>`

    $("#pts").html(loading);

    $.ajax({
        method: 'get',
        dataType: 'json',
        url: url,
        success: function (response) {
            if(response.status == 200){
                data = response.data || [];
                if (data.length < 1) {
                    $("#pts").html(empty);
                    return;
                }
                dataPts = response.data;
                $("#pts").html(processDataToHtml(response.data));
                return;
            }
        },
        error: function (error) {
            $("#pts").html(retryButton);
            $("#retry-button").on('click', function() {
                getAssessmentGroups();
            });
        }
    });
}

function processDataToHtml(data) {
    let html = "";
    data.forEach((d, index) => {
        html += (`
            <div id="pts-${index}" onclick="goSchedules(${index})" class="card-pts mt-4" role="button">
                <h3>
                    <i class="kejar-penilaian text-purple mr-4"></i>
                    <span id="pts-1">${d.title}</span>
                </h3>
            </div>
        `);
    })

    return html;
}


function goSchedules(index) {
    const id = dataPts[index].id;
    window.location.href = `/student/${id}/subjects`;
}


</script>
@endpush
