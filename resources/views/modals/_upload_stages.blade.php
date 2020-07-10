<div class="modal fade" id="upload-stages">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header border-0">
                <h5 class="modal-title">Unggah Babak</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/'. $game['uri'] .'/stages/upload') }}" method="post" enctype="multipart/form-data" id="stage-upload-form">
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <input type="text" name="stage_name" id="upload_stage_name" class="upload-stage-input" value="Pilih file" disabled>
                            <input type="file" name="stage_file" id="upload_stage_file" class="d-none" accept=".xlsx">
                        </div>
                        <div class="col-4">
                            <label for="upload_stage_file" class="btn btn-upload-stage pl-0">Pilih File</label>
                        </div>
                    </div>
                    <div class="mt-1 mb-3">
                        <a href="https://docs.google.com/spreadsheets/d/1Ql1X_7JOEauVTLbs8qHZdT2SeV-sr2jQfufXTeiFrI8/edit#gid=0" target="_blank" class="link-download">
                            <i class="kejar kejar-download"></i> Download File
                        </a>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <a href="#" class="link-create-stage d-block">
                        <i class="kejar kejar-add"></i> Buat babak
                    </a>
                    <div>
                        <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" onclick="document.getElementById('stage-upload-form').submit();">Unggah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
