<!-- Modal -->
<div class="modal fade" id="update-description" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Deskripsi Ronde</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ secure_url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id']) }}" method="post" id="update-description-form">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Deskripsi Ronde</label>
                        <textarea name="description" class="form-control" id="description" placeholder="Ketik deskripsi ronde" required>{{ $round['description'] }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="document.getElementById('update-description-form').submit();">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>