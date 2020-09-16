<div class="modal fade" id="update-material" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Materi Ronde</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id']) }}" method="post" id="update-material-form">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="material" class="font-weight-bold">Materi</label>
                        <textarea name="material" class="form-control" id="material" placeholder="Ketik materi ronde" required>{{ $round['material'] }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="document.getElementById('update-material-form').submit();">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
