<!-- Modal -->
<div class="modal fade" id="create-unit" tabindex="-1" role="dialog" aria-labelledby="create-unit" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form action="{{ url('admin/' . $game['uri'] . '/packages/' . $package['id'] . '/units') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($errors->has('title') || $errors->has('description'))
                    <p class="text-danger">Mohon isi judul unit dan deskripsi unit terlebih dahulu.</p>
                    @endif
                    <div class="form-group">
                        <label for="title">Judul Unit</label>
                        <input type="text" id="title" name="title" placeholder="Ketik judul unit" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi Unit</label>
                        <textarea name="description" id="description" cols="30" rows="3" placeholder="Tambahkan deskripsi unit" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div></div>
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>