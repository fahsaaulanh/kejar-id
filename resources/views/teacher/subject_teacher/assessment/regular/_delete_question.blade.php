<div class="modal fade" id="delete_question" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p class="font-15">Soal yang sudah dihapus tidak dapat dikembalikan. Hapus soal ini?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-right col-md-12">
                    <button type="button" id="lanjut-time-remaining" class="btn btn-link">Batal</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger" id="save-btn" onclick="editQuestionList('{{$assessments[0]['id']}}')">Hapus</button>
                </div>
                <div class="col-12 text-center mt-3" id="LoadingAssess3" style="display:none">
                    <div class="row justify-content-center">
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan...</span>
                        </div>
                    </div>
                    <div class="mt-2 row justify-content-center">
                        <h5>Sedang Menyimpan</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
