<!-- Modal -->
<div class="modal fade" id="editDescription" tabindex="-1" role="dialog" aria-labelledby="editDescription" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form action="{{ url('admin/' . $game['uri'] . '/stages/modal/stage/update/' . $stage['id']) }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Deskripsi Babak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description">Deskripsi Babak</label>
                        <textarea name="description" id="description" rows="4" cols="200" placeholder="Masukkan deskripsi babak" required>{{ $stage['description'] }}</textarea>
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