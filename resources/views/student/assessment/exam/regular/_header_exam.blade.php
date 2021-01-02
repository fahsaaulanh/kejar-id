<nav class="navbar navbar-expand-sm navbar-dark bg-black justify-content-between navbar-assesment">
    <a class="navbar-brand" href="#">
        <div class="nav-link text-white px-0">
            @if (session('user.role') === 'STUDENT')
            @if (!is_null(session('user.userable.photo')))
            <img src="" class="profile-pict" alt="">
            @else
            <img src="{{ asset('assets/images/general/photo-profile-default-circle.svg') }}" class="profile-pict assesment-picture" alt="">
            @endif
            @endif
            <div class="nav-name">
                {{ session('user.userable.name') }}
            </div>
        </div>
    </a>

    <div id="timer" class="assesment-timer text-white">
        00:00:00
    </div>

    <button class="navbar-toggler ml-2" type="button" data-toggle="dropdown" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="assessment-done" class="text-white assesment-btn-exit" role="button">
        Selesai
    </div>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a id="timer-dropdown" aria-disabled="true" disabled href="#" class="dropdown-item assesment-timer-dropdown" role="button">
            00:00:00
        </a>
        <a id="assessment-done-dropdown" href="#" class="dropdown-item" role="button">
            Selesai
        </a>
    </div>

</nav>
