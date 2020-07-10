<!-- Modal -->
<div class="modal fade" id="upload_question" tabindex="-1" role="dialog" aria-labelledby="upload_question" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title">Unggah Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/upload/questions') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center" id="form-upload-questions">
                    @csrf
                    <div class="col-8 p-0">
                        <input type="text" name="question_name" id="question_name" class="question_name" value="Pilih file" disabled>
                        <input type="file" name="question_file" id="question_file" class="d-none" accept=".xlsx">
                    </div>
                    <div class="col-4 m-0 p-0">
                        <label for="question_file" class="btn btn-choose-question">Pilih File</label>
                    </div>
                </form>
                <a href="https://docs.google.com/spreadsheets/d/1Ql1X_7JOEauVTLbs8qHZdT2SeV-sr2jQfufXTeiFrI8/edit#gid=0" target="_blank" class="text-download"><i class="kejar kejar-download"></i> Download File</a>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('form-upload-questions').submit();">Unggah</button>
            </div>
        </div>
    </div>
</div>
