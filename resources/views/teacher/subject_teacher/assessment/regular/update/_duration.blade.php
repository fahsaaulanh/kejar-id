<div class="modal fade" id="duration" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atur Durasi <br> <small>Durasi masih belum diatur. Atur durasi penilaian terlebih dahulu.</small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
            <form>
                <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="duration" class="font-weight-bold">Durasi (menit)</label>
                                <input id="duration_assess" type="number" class="form-control text-dark" name="duration" value="{{ $assessments[0]['duration'] }}" placeholder="Ketik durasi" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <div class="text-right col-md-12">
                    <button type="button" data-dismiss="modal" class="btn btn-link">Batal</button>
                    <button type="button" class="btn btn-primary" id="setDuration"
                    onclick="saveDuration('{{$assessmentGroupId}}', '{{$subject['id']}}', '{{$grade}}', '{{$assessments[0]['id']}}')">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
