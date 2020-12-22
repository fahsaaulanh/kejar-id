<div class="modal overFlow-scroll fade" id="updateScore" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Nilai Akhir</h5>
                <button type="button" class="close" onClick="closeModal()" aria-label="Close">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form>
                            <label for="title" class="font-weight-bold">Nilai Akhir</label><br>
                            <input class="form-control" name="score"  onchange="handleChange(this)" onkeyup="handleChange(this);" value="{{$task['final_score']}}" type="number" placeholder="Input nilai akhir" id="finalScore">
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel" onClick="closeModal()">Batal</button>
                    <button type="button" class="btn btn-primary" id="AddFinalScore" onClick="editScore()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>