@extends('layout.index')

@section('title', 'Permainan')

@section('content')

    @if($data['passwordDefault'])
        <!-- form ganti password -->
        <div class="bg-lego">
            <div class="container-center">
                <form class="card-384" action="{{ url('/' . strtolower(session('user.role') . '/change-password')) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <h3>Ganti Password</h3>
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
    @else
        <div class="bg-blue-tp">
            <div class="container-fluid">
                <div class="row dashboard">
                    <div class="col-12">
                        <div class="content-header">
                            <h1 class="content-title">Pilih permainan...</h1>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
