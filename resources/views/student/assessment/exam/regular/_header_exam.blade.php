<nav class="navbar navbar-expand-sm navbar-dark bg-black justify-content-between navbar-assesment">
    <a class="navbar-brand" href="#">
        <div class="nav-link text-white">
            @if (session('user.role') === 'STUDENT')
            @if (!is_null(session('user.userable.photo')))
            <img src="" class="profile-pict" alt="">
            @else
            <img src="{{ asset('assets/images/general/photo-profile-default-circle.svg') }}" class="profile-pict assesment-picture" alt="">
            @endif
            @endif
            {{ session('user.userable.name') }}
        </div>
    </a>

    <div class="text-white">
        01:00:00
    </div>

    <div class="text-white assesment-btn-exit" role="button">
        <i class="kejar-exit mr-2"></i>
        Keluar
    </div>

    <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ session('user.userable.name') }}
                    @if (session('user.role') === 'STUDENT')
                    @if (!is_null(session('user.userable.photo')))
                    <img src="" class="profile-pict" alt="">
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
    </div> -->
</nav>
