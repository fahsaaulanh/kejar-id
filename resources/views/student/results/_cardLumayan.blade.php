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
            <a href="{{ url('students/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/onboardings') }}" class="btn btn-restart">
                Ulangi
            </a>
            @if(count($nextRound) > 0)
            <a href="{{ url('students/games/' . $game . '/stages/' . $stageId . '/rounds/' . $nextRound['id'] . '/onboardings') }}" class="btn btn-next">
                Ronde Berikutnya
                <i class="kejar-arrow-right" aria-hidden="true"></i>
            </a>
            @endif
        </div>
    </div>
</div>