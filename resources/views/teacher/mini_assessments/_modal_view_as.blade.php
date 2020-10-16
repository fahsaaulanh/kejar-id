<div class="modal fade" id="ma-view-as">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Sebagai</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <form method="get" >
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <a href="#" id="select-ma-subject-teachers" class="col btn-ma-view-as text-dark mr-3">
                            <div class="icon">
                                <i class="kejar-guru"></i>
                            </div>
                            <span class="caption-left">Guru Mapel</span>
                        </a>
                        <a href="#" id="select-ma-student-counselor" class="col btn-ma-view-as text-dark ml-3">
                            <div class="icon">
                                <i class="kejar-wali-kelas"></i>
                            </div>
                            <span class="caption-right">Pembimbing Rayon</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
