<div class="modal fade" id="update-direction" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Petunjuk Ronde</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id']) }}" method="post" id="update-direction-form">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="direction" class="font-weight-bold">Petunjuk</label>
                        <textarea name="direction" class="form-control" id="direction" placeholder="Ketik petunjuk ronde" required>{{ $round['direction'] }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="document.getElementById('update-direction-form').submit();">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
