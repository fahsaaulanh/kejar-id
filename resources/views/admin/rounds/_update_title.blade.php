<!-- Modal -->
<div class="modal fade" id="editTitle" tabindex="-1" role="dialog" aria-labelledby="editTitle" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form action="{{ url('admin/' . $game['uri'] . '/stages/modal/stage/update/' . $stage['id']) }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Judul Babak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Judul Babak</label>
                        <input type="text" id="title" name="title" placeholder="Ketik judul babak" value="{{ $stage['title'] }}" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>