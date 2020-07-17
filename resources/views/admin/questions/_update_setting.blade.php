<!-- Modal -->
<div class="modal fade" id="update-setting" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pengaturan Ronde</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id']) }}" method="post" id="update-setting-form">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="total_question" class="font-weight-bold">Soal Ditampilkan</label>
                            <input type="text" class="form-control" id="total_question" name="total_question" placeholder="Ketik soal ditampilkan" required value="{{ $round['total_question'] }}">
                        </div>
                        <div class="form-group col-6">
                            <label for="question_timespan" class="font-weight-bold">Waktu per Soal (detik)</label>
                            <input type="text" class="form-control" id="question_timespan" name="question_timespan" placeholder="Ketik waktu per soal" required value="{{ $round['question_timespan'] }}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="document.getElementById('update-setting-form').submit();">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
