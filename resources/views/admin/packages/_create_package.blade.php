<!-- Modal -->
<div class="modal fade" id="create-package" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ url('admin/'. $game['uri'] .'/packages') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Paket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($errors->has('title') || $errors->has('description'))
                    <p class="text-danger">Mohon isi judul paket dan deskripsi paket terlebih dahulu.</p>
                    @endif
                    <div class="form-group">
                        <label for="title" class="font-weight-bold">Judul Paket</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Ketik judul babak" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Deskripsi Paket</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="4" placeholder="Tambahkan deskripsi babak" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div></div>
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>