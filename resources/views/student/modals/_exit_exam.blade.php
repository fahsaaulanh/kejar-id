<!-- Modal -->
<div class="modal fade" id="exitExamModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
                <div class="modal-header border-0">
                        <h5 class="modal-title font-weight-bold">Yakin Keluar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    Jika kamu keluar, aktivitas dan nilainya tidak tersimpan. Lanjut keluar?
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-transparent rounded-0" data-dismiss="modal">Batal</button>
                <a href="{{ url('student/' . $game . '/stages/' . $stageId . '/rounds') }}" class="btn btn-danger rounded-0">Keluar</a>
            </div>
        </div>
    </div>
</div>

