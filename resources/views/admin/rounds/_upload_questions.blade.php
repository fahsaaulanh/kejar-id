<div class="modal fade" id="upload_question">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Soal</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/upload-question') }}" method="POST" enctype="multipart/form-data" id="form-upload-questions">
                    @csrf
                    <div class="row custom-upload">
                        <div class="col-8">
                            <input type="text" name="question_name" id="question_name" value="Pilih file" disabled>
                            <input type="file" name="question_file" id="question_file" accept=".xlsx" required>
                        </div>
                        <div class="col-4">
                            <label for="question_file" class="btn btn-label">Pilih File</label>
                        </div>
                    </div>
                    <div class="mt-1 mb-3">
                        <a href="https://docs.google.com/spreadsheets/d/1s0HsPr75fwoiNbRW-_8r0eQdaQM7Q8gQl5iZMnGMN4g/export?format=xlsx" target="_blank" class="link-download"><i class="kejar kejar-download"></i> Download File</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('form-upload-questions').submit();">Unggah</button>
                </div>
            </div>
        </div>
    </div>
</div>
