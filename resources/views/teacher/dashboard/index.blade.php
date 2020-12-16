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
@php
    $loweredSchoolName = strtolower(session('user.userable.school_name'));
    $isWikrama = strpos($loweredSchoolName, 'wikrama') !== false;
@endphp
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
            @include('teacher.dashboard._assessment')
            @include('teacher.dashboard._akm')
            @include('teacher.dashboard._matrikulasi')
        </div>
    </div>
</div>
@include('teacher.dashboard.modals._view_as')
@include('teacher.dashboard.modals._add_assessment')
@endif
@endsection

@push('script')
<script src="{{ asset('assets/plugins/dropify/dist/js/dropify.js')}}"></script>
<script type="text/javascript">
    // Screen Variable
    let data = [];
    getAssessmentGroups();
    //

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

    $('#pts-tambah').on('click', function() {
        $('#modal-addAssessment').modal('show');
    });

    $("#form-addAssessment").on('submit', function(e) {
        e.preventDefault();
        createAssessmentGroup();
    });

    function showModal(index)
    {
        $('#modal-viewAs').modal('show');
    };

    function processDataToHtml(data) {
        let html = "";
        data.forEach((d, index) => {
            html += (`
                <div id="pts-${index}" class="card-pts mt-4" role="button" onclick="selectMA('${d.id}')">
                    <h3>
                        <i class="kejar-penilaian text-purple mr-4"></i>
                        <span id="pts-1">${d.title}</span>
                    </h3>
                </div>
            `);
        })

        return html;
    }

    function selectMA(val) {
        var urlSubjectTeachers = "{!! URL::to('/teacher/subject-teacher/') !!}"+"/"+val+"/subject";
        @if($isWikrama)
            var urlStudentCounselor = "{!! URL::to('/teacher') !!}"+"/"+val+"/student-counselor";
        @else
            var urlStudentCounselor = "{!! URL::to('/teacher') !!}"+"/"+val+"/student-groups";
        @endif
        var urlStudentSupervisor = "{!! URL::to('/teacher/supervisor/') !!}"+"/"+val+"/subject";
        $("#select-ma-subject-teachers").attr("href", urlSubjectTeachers);
        $("#select-ma-student-counselor").attr("href", urlStudentCounselor);
        $("#select-ma-pengawas").attr("href", urlStudentSupervisor);
        $('#modal-viewAs').modal('show');
    }

    function getAssessmentGroups() {
        const url = "{!! URL::to('/teacher/api/assessment-groups') !!}";
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

        $("#data-assessment").html(loading);
        $("#pts-tambah").hide();

        $.ajax({
            method: 'get',
            dataType: 'json',
            url: url,
            success: function (response) {
                if(response.status == 200){
                    data = response.data || [];
                    $("#pts-tambah").show();
                    if (data.length < 1) {
                        $("#data-assessment").html(empty);
                        return;
                    }

                    $("#data-assessment").html(processDataToHtml(response.data));
                    return;
                }
            },
            error: function (error) {
                $("#data-assessment").html(retryButton);
                $("#retry-button").on('click', function() {
                    getAssessmentGroups();
                });
            }
        });
    }

    function createAssessmentGroup() {
        const url = "{!! URL::to('/teacher/api/assessment-groups') !!}";
        const title = $('#title-addAssessment').val();
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
                    getAssessmentGroups();
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

@if(session('user.PasswordMustBeChanged') === true || session('user.changePhotoOnBoarding') === true)
    <script>
        $('#updatePassword').remove();
    </script>
@endif
@endpush
