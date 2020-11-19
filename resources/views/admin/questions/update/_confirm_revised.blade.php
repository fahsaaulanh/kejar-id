<div class="modal fade" id="update-revised" tabindex="-1" role="dialog" aria-labelledby="update-revised" aria-hidden="true" style="overflow-y: auto;">
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
                    <input type="hidden" name="status" value="NOT_PUBLISHED">
                    <p>Unit yang sedang direvisi tidak dapat diakses oleh siswa dan guru sekolah. Sebaiknya, lakukan revisi pada saat akses sangat rendah. Segera terbitkan kembali unit setelah proses revisi selesai.</p>
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Revisi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>