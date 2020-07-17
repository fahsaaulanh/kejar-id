<div class="score-result">
    <div class="stars-icon">
        <i class="kejar-arsip-asesmen-bold side-stars"></i>
        <i class="kejar-arsip-asesmen-bold middle-star"></i>
        <i class="kejar-arsip-asesmen side-stars-border"></i>
    </div>
    <h3 class="score-title">Lumayan!</h3>
    <p class="score-description">Masih ada yang salah tadi. Ulangi lagi yuk!</p>
    <br>
    <div class="res-container">
        <div class="row">
            <div class="col-md-4 p-2">
                <a href="{{ url('students/games') }}">
                    <button class="btn btn-block rounded-0 btn-restart">ulangi</button>
                </a>
            </div>
            <div class="col-md-8 p-2">
                <a href="{{ url('students/games') }}">
                    <button class="btn btn-block rounded-0 btn-next">Ronde Berikutnya
                        <i class="kejar-arrow-right" aria-hidden="true"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>