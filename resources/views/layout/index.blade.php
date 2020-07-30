<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="icon" href="{{ url('assets/logo/favicon.png') }}" type="image/gif">
        <!-- Styles -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        @yield('css')
    </head>
    <body>
        @section('header')
            @if(!Session::get('PasswordMustBeChanged') && !Session::get('changePhotoOnBoarding'))
                <nav class="navbar navbar-expand-sm navbar-dark bg-black">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('assets/logo/kejarid.svg') }}" alt=""> Kejar.id
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ session('user.userable.name') }}
                                    @if (session('user.role') === 'STUDENT')
                                        @if (!is_null(session('user.userable.photo')))
                                            <img src="{{ session('user.userable.photo') }}" class="profile-pict" alt="">
                                        @else
                                        <img src="{{ asset('assets/images/general/photo-profile-default-circle.svg') }}" class="profile-pict" alt="">
                                        @endif
                                    @endif
                                    <i class="kejar-dropdown"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (session('user.role') === 'STUDENT')
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProfile"><i class="kejar-profile"></i> Ganti Foto Profil</a>
                                @endif
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updatePassword"><i class="kejar-password"></i> Ganti Password</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logout"><i class="kejar-log-out"></i> Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            @endif
        <nav class="navbar navbar-expand-sm navbar-dark bg-black">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/logo/kejarid.svg') }}" alt=""> Kejar.id
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ session('user.userable.name') }}
                            @if (session('user.role') === 'STUDENT')
                                @if (!is_null(session('user.userable.photo')))
                                <img src="" class="profile-pict" alt="">
                                @else
                                <img src="https://jgi.doe.gov/wp-content/uploads/2014/04/Steven_Hallam-slide.jpg" class="profile-pict" alt="">
                                @endif
                            @endif
                            <i class="kejar-dropdown"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if (session('user.role') === 'STUDENT')
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProfile"><i class="kejar-profile"></i> Ganti Foto Profil</a>
                            @endif
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updatePassword"><i class="kejar-password"></i> Ganti Password</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logout"><i class="kejar-log-out"></i> Log Out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        @show

        @yield('content')

        @include('shared._update_avatar')
        @include('shared._update_password')

        <!-- Modal -->
        <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="logout" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Log Out</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        Apakah yakin akan keluar?
                    </div>
                    <div class="modal-footer justify-content-end">
                        <div>
                            <a href="#" class="btn btn-cancel" data-dismiss="modal">Batal</a>
                            <a href="{{ url('/logout') }}" class="btn btn-danger btn-logout">Keluar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="https://www.jqueryscript.net/demo/Responsive-Mobile-friendly-Image-Cropper-With-jQuery-rcrop/dist/rcrop.min.js"></script>

    @stack('script')
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117909356-4"></script>
    <script src="https://www.jqueryscript.net/demo/Responsive-Mobile-friendly-Image-Cropper-With-jQuery-rcrop/dist/rcrop.min.js"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-117909356-4');
    </script>

    @if($errors->has('password_baru') OR $errors->has('konfirmasi_password') )
    <script>
        $('#updatePassword').modal('show');
    </script>
    @endif

    @if(Session::has('message'))
    <script>
        alert("{{ Session::get('message') }}");
    </script>
    @endif
    <!-- Import JS Script -->
    @yield('script')

    <script>
        $(document).ready(function() {
            $(".input-group-password").on('click', 'button', function(event) {
                event.preventDefault();
                var input = $(this).parents('.input-group-password').find('input');
                if ($(input).attr('type') == 'password'){
                    $(input).attr('type', 'text');
                    $(this).html('<i class="kejar-show-password"></i>');
                } else{
                    $(this).html('<i class="kejar-hide-password"></i>');
                    $(input).attr('type', 'password');
                }
            });
        });

        $(document).on('click', '.edit-pict-btn', function(){
            var checkPicture = $('.avatar-group .profile-pict').attr('data-pict');
            if (checkPicture == 'notNull') {
                $('#editProfile').modal('hide');
                $('#updateProfile').modal('show');
                setInterval(function(){
                    $('.profile-pict-crop').rcrop({
                        minSize : [200,200],
                        preserveAspectRatio : true,
                        grid : true
                    });
                }, 200);
            } else {
                $('input[name=photo]').click();
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.avatar-group .profile-pict').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("input[name=photo][type=file]").change(function(){
            readURL(this);
        });

        $('#editProfile').on('hidden.bs.modal', function (e) {
            var checkPicture = $('.avatar-group .profile-pict').attr('data-pict');
            if (checkPicture == 'Null') {
                $('.avatar-group .profile-pict').attr('src', $('.nav-link img').attr('src'));
            }
            $('#editProfile').modal('hide');
            $('#updateProfile').modal('show');
            setInterval(function(){
                $('.profile-pict-crop').rcrop({
                    minSize : [200,200],
                    preserveAspectRatio : true,
                    grid : true
                });
            }, 200);
        });

        $(document).on('click', '.save-btn-2', function(){
            var srcResized = $('.profile-pict-crop').rcrop('getDataURL');
            $('.avatar-group .profile-pict').attr('src', srcResized);
            $('input[name=photo]').val(srcResized);
            $('#editProfile').modal('show');
            $('#updateProfile').modal('hide');
        });

        $(document).on('click', '.cancel-edit', function(){
            $('#editProfile').modal('show');
            $('#updateProfile').modal('hide');
        });
    </script>
</html>
