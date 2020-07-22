<div class="row">
    <div class="col-12">
        <div class="modal modal-custom fade" id="descriptionEditModal" tabindex="-1" role="dialog" aria-labelledby="descriptionEditModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" name="updateDescriptionForm" action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/modal/round/update/'. $round['id']) }}">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="descriptionEditModalLabel">Edit Deskripsi Ronde</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i class="kejar-close"></i>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <input type="hidden" name="field" value="description">
                      <div class="col-12">
                          <div class="form-group">
                              <label class="form-title" for="descriptionTextArea">Deskripsi Ronde</label>
                              <textarea class="form-control" id="descriptionTextArea" rows="7" placeholder="Ketik deskripsi ronde di sini..." name="description" required="">{{ $round['description'] }}</textarea>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('dblclick', '.round-detail:nth-child(2) h5', function () {
      $('#descriptionEditModal').modal('show');
    });

    $(document).on('dblclick', '.round-detail:nth-child(2) p', function () {
      $('#descriptionEditModal').modal('show');
    });
</script>
