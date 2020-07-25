<div class="modal fade" id="uploadRoundModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Ronde</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/upload') }}" enctype="multipart/form-data" id="round-upload-form">
                    @csrf
                    <div class="row custom-upload">
                        <div class="col-8">
                            <input type="text" name="file_name" id="upload_round_name" class="input-file" value="Pilih file" disabled>
                            <input type="file" name="excel_file" id="upload_round_file" accept=".xlsx" required>
                        </div>
                        <div class="col-4">
                            <label for="upload_round_file" class="btn btn-label">Pilih File</label>
                        </div>
                    </div>
                    <div class="mt-1 mb-3">
                        <a href="https://docs.google.com/spreadsheets/d/1E19sx_M7-db5zZ9lwDv0arvB7aDmVQnrimUoRR2lEOM/export?format=xlsx" target="_blank" class="link-download"><i class="kejar-download"></i> Download Format</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" role="button" class="d-block" data-toggle="modal" data-target="#createRoundModal">
                    <i class="kejar kejar-add"></i> Buat Ronde
                </a>
                <div>
                    <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" onclick="document.getElementById('round-upload-form').submit();">Unggah</button>
                </div>
            </div>
        </div>
    </div>
</div>
