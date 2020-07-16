<div class="modal fade" id="upload-rounds">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Ronde</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/'. $game['uri'] .'/stages/upload-rounds') }}" method="post" enctype="multipart/form-data" id="round-upload-form">
                    @csrf
                    <div class="row custom-upload">
                        <div class="col-8">
                            <input type="text" name="round_name" id="upload_round_name" class="input-file" value="Pilih file" disabled>
                            <input type="file" name="round_file" id="upload_round_file" accept=".xlsx">
                        </div>
                        <div class="col-4">
                            <label for="upload_round_file" class="btn btn-label">Pilih File</label>
                        </div>
                    </div>
                    <div class="mt-1 mb-3">
                        <a href="https://docs.google.com/spreadsheets/d/13p2-n1No459D64KjvSa6y0rhUO7ou9IwPX-_inJJQXw/export?format=xlsx" target="_blank" class="link-download">
                            <i class="kejar kejar-download"></i> Download File
                        </a>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" onclick="document.getElementById('round-upload-form').submit();">Unggah</button>
                </div>
            </div>
        </div>
    </div>
</div>