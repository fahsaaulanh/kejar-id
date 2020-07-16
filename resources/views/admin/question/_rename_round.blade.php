    <div class="modal fade" id="updateRoundTitle" tabindex="-1" role="dialog" aria-labelledby="updateRoundTitle" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <form method="POST" id="updateRoundTitle" action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/modal/round/update/'. $round['id']) }}">
                    @csrf
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-modal-title" id="exampleModalLongTitle">Edit Judul Ronde</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="field" value="title">
                        <div class="form-group">
                            <label class="font-label-modal" for="name">Judul Babak</label>
                            <input class="form-control rounded-0" type="text" name="title" id="name" autocomplete="off" placeholder="Ketik judul babak" required value="{{$round['title']}}">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</form>
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script type="text/javascript">
    $(document).on('dblclick', '.text-title', function () {
      $('#updateRoundTitle').modal('show');
    });
</script>