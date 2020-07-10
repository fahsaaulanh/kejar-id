<form method="POST" id="UpdateRoundDirection" action="{{ url($game.'/stages/'.$stageId.'/rounds/'.$roundId)}}">
    @csrf
    <div class="modal fade" id="updateRoundDirection" tabindex="-1" role="dialog" aria-labelledby="updateRoundDirection" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-modal-title" id="exampleModalLongTitle">Edit Petunjuk Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="font-label-modal" for="name">Petunjuk Soal</label>
                    <textarea class="form-control rounded-0" rows="5" id="direction" name="direction" placeholder="Tambahkan deskripsi babak" autocomplete="off">{{$data['direction']}}</textarea>
                </div>
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-cancel font-button" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-modal-save font-button" id="submit" >Simpan</button>
        </div>
    </div>
</form>
