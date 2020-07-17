<!-- Modal -->
<div class="modal fade" id="rename-round" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Judul Ronde</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ secure_url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id']) }}" method="post" id="rename-round-form">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title" class="font-weight-bold">Judul Ronde</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Ketik judul ronde" required value="{{ $round['title'] }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="document.getElementById('rename-round-form').submit();">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>