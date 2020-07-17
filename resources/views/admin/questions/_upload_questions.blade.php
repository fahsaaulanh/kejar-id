<div class="modal fade" id="upload-questions">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Soal</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ secure_url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/upload') }}" method="post" enctype="multipart/form-data" id="question-upload-form">
                    @csrf
                    <div class="row custom-upload">
                        <div class="col-8">
                            <input type="text" name="question_name" id="upload_question_name" class="input-file" value="Pilih file" disabled>
                            <input type="file" name="question_file" id="upload_question_file" accept=".xlsx">
                        </div>
                        <div class="col-4">
                            <label for="upload_question_file" class="btn btn-label">Pilih File</label>
                        </div>
                    </div>
                    <div class="mt-1 mb-3">
                        <a href="https://docs.google.com/spreadsheets/d/1s0HsPr75fwoiNbRW-_8r0eQdaQM7Q8gQl5iZMnGMN4g/export?format=xlsx" target="_blank" class="link-download">
                            <i class="kejar kejar-download"></i> Download File
                        </a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="" data-toggle="modal" data-target="#create-question">
                    <i class="kejar kejar-add"></i> Input Soal
                </a>
                <div>
                    <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" onclick="document.getElementById('question-upload-form').submit();">Unggah</button>
                </div>
            </div>
        </div>
    </div>
</div>
