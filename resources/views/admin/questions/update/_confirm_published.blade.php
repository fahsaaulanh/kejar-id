<div class="modal fade" id="update-published" tabindex="-1" role="dialog" aria-labelledby="update-published" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id']) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terbitkan Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" value="PUBLISHED">
                    <p>Pastikan konten sudah sempurna. Lanjut terbitkan unit?</p>
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cek Kembali</button>
                        <button type="submit" class="btn btn-primary">Terbitkan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>