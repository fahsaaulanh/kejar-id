<div class="modal fade" id="validationAnswer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validasi</h5>
                <button type="button" class="close" onclick="closeValidation()" aria-label="Close">
                    <i class="kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p class="font-15">Tandai bahwa paket soal beserta kunci jawaban sudah divalidasi.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-link" onclick="closeValidation()">Batal</button>
                    <button type="button" class="btn btn-primary" id="validasiButton"  onclick="validationAssessment()">Validasi</button>
                </div>
            </div>
        </div>
    </div>
</div>