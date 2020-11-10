<div class="modal" id="update-isian-matematika">
    <div class="modal-dialog modal-fix">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Soal Isian Matematika</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="update-isian-matematika-form">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="question_type" value="MQIA">
                    <div class="form-group ckeditor-list">
                        <label for="keterangan-soal">Soal</label>
                        <textarea name="keterangan_soal" class="editor-field" cols="30" rows="3" placeholder="Ketik soal"></textarea>
                        <div class="ckeditor-btn-group ckeditor-btn-1 d-none">
                            <button type="button" class="bold-btn" title="Bold (Ctrl + B)">
                                <i class="kejar-bold"></i>
                            </button>
                            <button type="button" class="italic-btn" title="Italic (Ctrl + I)">
                                <i class="kejar-italic"></i>
                            </button>
                            <button type="button" class="underline-btn" title="Underline (Ctrl + U)">
                                <i class="kejar-underlined"></i>
                            </button>
                            <button type="button" class="bullet-list-btn" title="Bulleted list">
                                <i class="kejar-bullet"></i>
                            </button>
                            <button type="button" class="number-list-btn" title="Number list">
                                <i class="kejar-number"></i>
                            </button>
                            <button type="button" class="photo-btn" title="Masukkan foto">
                                <i class="kejar-photo"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pertanyaan">Jawaban</label>
                        <table class="isian-matematika-input-table" data-type="isian_matematika">

                        </table>
                        <a href="#" class="add-btn" data-type="isian_matematika" id="add-btn"><i class="kejar-add"></i> <span>Tambah Jawaban</span></a>
                    </div>
                    <div class="form-group ckeditor-list">
                        <label for="pembahasan">Pembahasan</label>
                        <textarea name="pembahasan" class="editor-field" cols="30" rows="3" placeholder="Ketik Pembahasan"></textarea>
                        <div class="ckeditor-btn-group ckeditor-btn-1 d-none">
                            <button type="button" class="bold-btn" title="Bold (Ctrl + B)">
                                <i class="kejar-bold"></i>
                            </button>
                            <button type="button" class="italic-btn" title="Italic (Ctrl + I)">
                                <i class="kejar-italic"></i>
                            </button>
                            <button type="button" class="underline-btn" title="Underline (Ctrl + U)">
                                <i class="kejar-underlined"></i>
                            </button>
                            <button type="button" class="bullet-list-btn" title="Bulleted list">
                                <i class="kejar-bullet"></i>
                            </button>
                            <button type="button" class="number-list-btn" title="Number list">
                                <i class="kejar-number"></i>
                            </button>
                            <button type="button" class="photo-btn" title="Masukkan foto">
                                <i class="kejar-photo"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" onclick="document.getElementById('update-isian-matematika-form').submit();">Simpan</button>
            </div>
        </div>
    </div>
</div>
