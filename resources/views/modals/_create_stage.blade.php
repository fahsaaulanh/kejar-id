<!-- Modal -->
<div class="modal fade" id="createStageModal" tabindex="-1" role="dialog" aria-labelledby="createStageModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <form action="{{ url('admin/'. $game['uri'] .'/stages/create') }}" method="post" id="createStageForm">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title">Buat Babak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body border-0"> 
                    <div class="form-group">
                        <label for="title" class="font-weight-bold">Judul Babak</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Ketik judul babak" required="">
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Deskripsi Babak</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="3" placeholder="Tambahkan deskripsi babak" required=""></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between border-0">
                    <div>
                        <a href="#" class="link-modal-primary" data-dismiss="modal"><i class="kejar kejar-upload"></i> Upload Babak</a>
                    </div>
                    <div>
                        <button type="button" class="btn btn-modal-transparent btn-modal btn-transparent" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-modal-primary btn-modal">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>