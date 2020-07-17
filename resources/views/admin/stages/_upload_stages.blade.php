<div class="modal fade" id="upload-stages">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Babak</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/'. $game['uri'] .'/stages/upload') }}" method="post" enctype="multipart/form-data" id="stage-upload-form">
                    @csrf
                    <div class="row custom-upload">
                        <div class="col-8">
                            <input type="text" name="stage_name" id="upload_stage_name" class="input-file" value="Pilih file" disabled>
                            <input type="file" name="stage_file" id="upload_stage_file" accept=".xlsx">
                        </div>
                        <div class="col-4">
                            <label for="upload_stage_file" class="btn btn-label">Pilih File</label>
                        </div>
                    </div>
                    <div class="mt-1 mb-3">
                        <a href="https://docs.google.com/spreadsheets/d/1qQF00gweLOW1S6KzW1Q_xTEkJ78Vhfo5IDsb5awcqaI/export?format=xlsx" target="_blank" class="link-download">
                            <i class="kejar kejar-download"></i> Download File
                        </a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="link-create-stage d-block" data-toggle="modal" data-target="#createStageModal">
                    <i class="kejar kejar-add"></i> Buat Babak
                </a>
                <div>
                    <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" onclick="document.getElementById('stage-upload-form').submit();">Unggah</button>
                </div>
            </div>
        </div>
    </div>
</div>
