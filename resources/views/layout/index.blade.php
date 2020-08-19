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
                                @if (session('user.role') !== 'ADMIN')
                                    @if (session('user.photoExistCheck') === true)
                                    <img src="{{ session('user.userable.photo') }}" class="profile-pict" alt="">
                                    @else
                                    <img src="{{ asset('assets/images/profile/default-picture.jpg') }}" class="profile-pict" alt="">
                                    @endif
                                @endif

                                <i class="kejar-dropdown"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (session('user.role') !== 'ADMIN')
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProfile"><i class="kejar-profile"></i> Ganti Foto Profil</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updatePassword"><i class="kejar-password"></i> Ganti Password</a>
                                @endif
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logout"><i class="kejar-log-out"></i> Log Out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        @show

        @yield('content')

        @if (session('user.role') !== 'ADMIN')
        @include('shared._update_avatar')
        @include('shared._update_password')
        @endif

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

        <!-- Alert Notification -->
        <div class="toast p-3 border-0 shadow rounded bg-white" data-delay="5000">
            <div class="toast-header border-0">
                <img src="{{ asset('assets/logo/favicon.png') }}" class="rounded mr-2" alt="...">
                <strong class="mr-auto">Kejar.id</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body py-3">
                <h6>{{ Session::get('message') }}</h6>
            </div>
        </div>

    </body>
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>

    @stack('script')
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117909356-4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.js" integrity="sha512-giNJUOlLO0dY67uM6egCyoEHV/pBZ048SNOoPH4d6zJNnPcrRkZcxpo3gsNnsy+MI8hjKk/NRAOTFVE/u0HtCQ==" crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-117909356-4');
    </script>

    @if(!empty($errors))
    @if($errors->has('password_baru') OR $errors->has('konfirmasi_password') )
    <script>
        $('#updatePassword').modal('show');
    </script>
    @endif
    @endif

    @if(Session::has('message'))
    <script>
        $('.toast').toast('show');
    </script>
    @endif

    @if(Session::has('profile_updated'))
    <script>
        $('#editProfile').modal('show');
        alert("{{ Session::get('profile_updated') }}");
    </script>
    @endif

    <script>
        var image = document.getElementsByClassName("profile-pict-crop")[0];
        var cropper;
        var photo;

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

        $(document).on('click', '#updateProfile .btn-cancel', function(){
            modalProfileManagement('cancelUpdate');
        });

        $(document).on('click', '.edit-pict-btn', function(){
            $('input[name=select_photo]').click();
        });

        $('input[name=select_photo]').change(function(){
            readURL(this);
        });

        $(document).on('click', '#save-btn', function(){
            photo = cropper.getCroppedCanvas().toDataURL();
            modalProfileManagement('saveProfile');
        });

        $('#updateProfile').on('shown.bs.modal', function(){
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
            });
        }).on('hidden.bs.modal', function(){
            modalProfileManagement('cancelUpdate');
            cropper.destroy();
            cropper = null;
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.profile-pict-crop').attr('src', e.target.result);
                    modalProfileManagement('selectPicture');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    @if(session('user.changePhotoOnBoarding') === true)
    <script>
        function modalProfileManagement(status) {
            if (status == 'saveProfile'){
                $('input[name=photo_onboarding]').val(photo);
                $('form[name=change_profile_onboarding]').submit();
            } else if (status == 'cancelUpdate') {
                $('.dropify-clear').click();
                $('#updateProfile').modal('hide');
            } else if (status == 'selectPicture') {
                $('#updateProfile').modal('show');
            }
        }
    </script>
    @else
    <script>
        function modalProfileManagement(status) {
            if (status == 'saveProfile'){
                $('input[name=photo]').val(photo);
                $('form[name=change_profile]').submit();
            } else if (status == 'cancelUpdate') {
                $('#editProfile').modal('show');
                $('#updateProfile').modal('hide');
            } else if (status == 'selectPicture') {
                $('#editProfile').modal('hide');
                $('#updateProfile').modal('show');
            }
        }
    </script>
    @endif
</html>
