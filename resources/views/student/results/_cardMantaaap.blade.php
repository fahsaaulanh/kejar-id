<div class="score-result">
    <div class="stars-icon">
        <i class="kejar-arsip-asesmen-bold side-stars"></i>
        <i class="kejar-arsip-asesmen-bold middle-star"></i>
        <i class="kejar-arsip-asesmen-bold side-stars"></i>
    </div>
    <h3 class="score-title">Mantaaap!</h3>
    <p class="score-description">Kamu berhasil menjawab soal dengan benar!</p>
    <br>
    <div class="res-container">
        <div class="row">
            <a href="{{ url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/onboardings') }}" class="btn btn-restart">
                Ulangi
            </a>
            <a href="{{ count($nextRound) > 0 ? url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $nextRound['id'] . '/onboardings') : url('student/games/' . $game . '/stages/' . $stageId . '/rounds') }}" class="btn btn-next">
                Ronde Berikutnya
                <i class="kejar-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
<script>
    $('.close-icon').on('click', function() {
        window.location.href = "{{URL::to('/student/games')}}"
    });
    $('.btn-restart').on('click', function() {
        window.location.href = "{{URL::to('/student/games')}}"
    });
    $('.btn-next').on('click', function() {
        window.location.href = "{{URL::to('/student/games')}}"
    });
</script>
