@php
    $loweredSchoolName = strtolower(session('user.userable.school_name'));
    $isWikrama = strpos($loweredSchoolName, 'wikrama') !== false;
@endphp
<div class="modal fade" id="modal-viewAs">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header pt-2 px-0">
                <h5 class="modal-title">Lihat Sebagai</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row px-2">
                    <a id="select-ma-subject-teachers" class="text-decoration-none col btn-ma-view-as text-dark mr-3">
                        <div class="icon">
                            <i class="kejar-guru"></i>
                        </div>
                        <span class="caption">Guru Mapel</span>
                    </a>
                    <a id="select-ma-pengawas" class="text-decoration-none col btn-ma-view-as text-dark mr-3">
                        <div class="icon">
                            <i class="kejar-guru"></i>
                        </div>
                        <span class="caption">Pengawas</span>
                    </a>
                    <a id="select-ma-student-counselor" class="text-decoration-none col btn-ma-view-as text-dark">
                        <div class="icon">
                            <i class="kejar-wali-kelas"></i>
                        </div>
                        @if($isWikrama)
                        <span class="caption">Pembimbing Rayon</span>
                        @else
                        <span class="caption">Wali Kelas</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
