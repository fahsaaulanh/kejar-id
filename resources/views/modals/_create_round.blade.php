<!-- Modal -->
<div class="modal fade" id="createRoundModal" tabindex="-1" role="dialog" aria-labelledby="createRoundModal" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/create') }}" method="post">
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
                        <label for="title" class="font-weight-bold">Judul Ronde</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Ketik judul ronde" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="question_showed" class="font-weight-bold">Soal Ditampilkan</label>
                            <input type="number" class="form-control" id="question_showed" name="question_showed" placeholder="Banyaknya soal" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="timespan" class="font-weight-bold">Waktu Persoal (detik)</label>
                            <input type="number" class="form-control" name="timespan" id="timespan" placeholder="Waktu per soal" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Deskripsi</label>
                        <textarea name="description" id="description" cols="30" rows="3" placeholder="Tambahkan deskripsi ronde" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="direction" class="font-weight-bold">Petunjuk Soal</label>
                        <textarea name="direction" id="direction" cols="30" rows="3" placeholder="Tambahkan petunjuk soal" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <a href="#" class="link-modal-primary" data-dismiss="modal"><i class="kejar kejar-upload"></i> Unggah Ronde</a>
                    </div>
                    <div>
                        <button type="button" class="btn btn-modal-transparent btn-modal" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-modal-primary btn-modal">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>