<!-- Modal -->
<div class="modal fade" id="update-question" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="update-question-form">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="question" class="font-weight-bold">Soal</label>
                            <input type="text" class="form-control" id="question" name="question" placeholder="Ketik soal" required value="">
                        </div>
                        <div class="form-group col-12">
                            <label for="answer" class="font-weight-bold">Jawaban</label>
                            <input type="text" class="form-control" id="answer" name="answer" placeholder="Ketik jawaban" required value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" onclick="document.getElementById('update-question-form').submit();">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>