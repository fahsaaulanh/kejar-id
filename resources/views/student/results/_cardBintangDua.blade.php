<div class="score-result">
    <div class="stars-icon">
        <i class="kejar-arsip-asesmen side-stars-border"></i>
        <i class="kejar-arsip-asesmen middle-star-border"></i>
        <i class="kejar-arsip-asesmen side-stars-border"></i>
    </div>
    <h3 class="score-title">Yaah...</h3>
    <p class="score-description">Semangat, ya! Pasti kamu bisa kalau terus mengulang.</p>
    <br>
    <div class="res-container">
        <div class="row">
            <a href="{{ url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/onboardings') }}" class="btn btn-retry">
                Coba Lagi
            </a>
        </div>
    </div>
</div>
