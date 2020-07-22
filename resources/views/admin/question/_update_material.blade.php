<div class="row">
    <div class="col-12">
        <div class="modal modal-custom fade" id="materialEditModal" tabindex="-1" role="dialog" aria-labelledby="materialEditModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" name="updateMaterialForm" action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/modal/round/update/'. $round['id']) }}">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="materialEditModalLabel">Edit Materi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i class="kejar-close"></i>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <input type="hidden" name="field" value="material">
                      <div class="col-12">
                          <div class="form-group">
                              <label class="form-title" for="materiTextArea">Materi</label>
                              <textarea class="form-control" id="materiTextArea" rows="7" placeholder="Ketik materi di sini..." name="material" required="">{{ $round['material'] }}</textarea>
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
    $(document).on('dblclick', '.round-detail:nth-child(3) h5', function () {
      $('#materialEditModal').modal('show');
    });

    $(document).on('dblclick', '.round-detail:nth-child(3) p', function () {
      $('#materialEditModal').modal('show');
    });
</script>
