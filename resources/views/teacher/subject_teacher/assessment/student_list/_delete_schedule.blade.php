<div class="modal fade" id="deleteSchecule" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Penugasan</h5>
                <button type="button" class="close" onclick="closeDelete()" aria-label="Close">
                    <i class="kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p class="font-15">Hapus penugasan siswa-siswa yang dipilih ?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="lanjut-time-remaining" onclick="closeDelete()" class="btn btn-link">Batal</button>
                    <button type="button" class="btn btn-danger"  onclick="deleteData()" id="deleteAssgin">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>
