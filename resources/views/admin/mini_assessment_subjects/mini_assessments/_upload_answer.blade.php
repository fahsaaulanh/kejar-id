<div class="modal fade" id="upload-ma-answer">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Jawaban</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <form method="post" id="UploadAnswers" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row custom-upload">
                        <div class="col-8">
                            <input type="text" name="stage_name" id="upload_stage_name" class="input-file" value="Pilih file" disabled>
                            <input type="file" name="upload_file" id="upload_file" accept=".xlsx">
                        </div>
                        <div class="col-4">
                            <label for="upload_file" class="btn btn-label">Pilih File</label>
                        </div>
                    </div>
                    <div class="mt-1 mb-3">
                        <a href="https://docs.google.com/spreadsheets/d/1iJrFLqp3PiZ01wwOyY8zmBkVDdXX12zQQ7Zxqzs1Ums/export?format=xlsx" target="_blank" class="link-download">
                            <i class="kejar kejar-download"></i> Unduh Format
                        </a>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <div class="text-right col-md-12">
                        <button class="btn btn-cancel pull-right" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary pull-right">Unggah</button>
                    </div>
                    <div class="col-12 text-center mt-3" id="loading_upload_file" style="display:none">
                        <div class="row justify-content-center">
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Mengupload...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Mengupload...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Mengupload...</span>
                            </div>
                        </div>
                        <div class="mt-2 row justify-content-center">
                            <h5>Sedang Mengupload</h5>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
