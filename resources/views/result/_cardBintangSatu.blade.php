
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card rounded-0 mt-5 size-card">
                <div class="card-body">
                    <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="kejar-close close-position"></i></span>
                      <hr class="border-0">
                    <div class="score-result">
                        <div class="stars-icon">
                             <i class="kejar-arsip-asesmen-bold side-stars"></i>
                             <i class="kejar-arsip-asesmen middle-star-border"></i>
                             <i class="kejar-arsip-asesmen side-stars-border"></i>
                            </div>
                        <h3 class="score-title">Yaah...</h3>
                        <p class="score-description">Semangat, ya! Pasti kamu bisa kalau terus mengulang.</p>
                        <br>
                        <div class="res-container">
                            <div class="row">
                                <div class="col p-2">
                                    <button class="rounded-0 btn-retry">Coba Lagi
                                    </button>
                                    </button>
                                </div>
                            </div>
                        {{-- <button class="btn-restart rounded-0">Ulangi</button>
                        <button class="btn-next rounded-0">Ronde Berikutnya <i class="kejar-arrow-right"></i></button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.close-icon').on('click',function() {
        window.location.href = "{{URL::to('/dashboard')}}"
    });
</script>
