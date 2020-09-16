<!-- Modal -->
<div class="modal fade" id="createRoundModal" tabindex="-1" role="dialog" aria-labelledby="createRoundModal" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Ronde</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul Ronde</label>
                        <input type="text" id="title" name="title" placeholder="Ketik judul ronde" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="question_showed">Soal Ditampilkan</label>
                            <input type="number" id="question_showed" name="question_showed" placeholder="Banyaknya soal" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="timespan">Waktu Persoal (detik)</label>
                            <input type="number" name="timespan" id="timespan" placeholder="Waktu per soal" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" id="description" cols="30" rows="3" placeholder="Tambahkan deskripsi ronde"></textarea>
                    </div>
                    @if($game['uri'] !== 'soalcerita')
                    <div class="form-group">
                        <label for="direction">Petunjuk Soal</label>
                        <textarea name="direction" id="direction" cols="30" rows="3" placeholder="Tambahkan petunjuk soal"></textarea>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <a href="#" role="button" data-dismiss="modal">
                        <i class="kejar kejar-upload"></i> Unggah Ronde
                    </a>
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>