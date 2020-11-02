<div class="modal fade modal-large" id="update-mengurutkan">
    <div class="modal-dialog" role="document">
        <form action="" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="question_type" value="SSQ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Soal Mengurutkan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Keterangan Soal</label>
                        <textarea class="editor-field" id="ur_question_field" name="question[question]" placeholder="Ketik keterangan soal"></textarea>
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
                        <label>Pernyataan/Kalimat</label>
                        <p>Isi dengan berurutan. Pernyataan/kalimat akan ditampilkan secara acak.</p>
                        <table class="answer-list-table-ur mengurutkan-input-table" data-type="mengurutkan">
                            
                        </table>
                        <button class="btn btn-add border-0 pl-0 add-btn" type="button" data-type="mengurutkan">
                            <i class="kejar-add"></i> Tambah Pernyataan/Kalimat
                        </button>
                    </div>
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Pembahasan</label>
                        <textarea class="editor-field" id="ur_description_field" name="question[description]" placeholder="Ketik pembahasan"></textarea>
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
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>