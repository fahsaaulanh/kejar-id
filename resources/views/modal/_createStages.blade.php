<form method="POST" id="CreateStagesModal" action="{{ url('/'. $game['uri'] .'/stages/') }}">
    @csrf
    <div class="modal fade" id="createStagesModal" tabindex="-1" role="dialog" aria-labelledby="createStagesModal" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-modal-title" id="exampleModalLongTitle">Buat Babak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="font-label-modal" for="name">Judul Babak</label>
                    <input class="form-control rounded-0" type="text" name="title" id="name" autocomplete="off" placeholder="Ketik judul babak" required>
                </div>
                <div class="form-group">
                    <label class="font-label-modal" for="description">Deskripsi Babak</label>
                    <textarea class="form-control rounded-0" rows="5" id="description" name="description" placeholder="Tambahkan deskripsi babak" autocomplete="off"></textarea>
                </div>
                <div class="form-group">
                        <button type="button" class="btn btn-link font-modal-download" data-toggle="modal" data-target="#uploadStagesModal">
                           <i class="kejar-upload mb-1">   </i>Unggah Babak
                        </button>
                </div>
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-cancel font-button" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-modal-save font-button" id="submit" >Simpan</button>
        </div>
    </div>
</form>