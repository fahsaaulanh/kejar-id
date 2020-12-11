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

    <div id="timer" class="text-white">
        00:00:00
    </div>

    <div id="assessment-done" class="text-white assesment-btn-exit" role="button">
        Selesai
    </div>
</nav>
