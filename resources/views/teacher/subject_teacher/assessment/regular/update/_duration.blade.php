<div class="modal fade" id="duration" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atur Durasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="duration" class="font-weight-bold">Durasi</label>
                            <input id="duration_assess" type="number" class="form-control" name="duration" placeholder="Ketik durasi" required="" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-right col-md-12">
                    <button type="button" id="lanjut-time-remaining" class="btn btn-link">Batal</button>
                    <button type="button" class="btn btn-primary" id="setDuration"
                    onclick="saveDuration('{{$assessmentGroupId}}', '{{$subject['id']}}', '{{$grade}}', '{{$assessments[0]['id']}}')">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
