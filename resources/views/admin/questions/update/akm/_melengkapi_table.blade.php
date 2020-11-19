<div class="modal fade" id="update-melengkapi-tabel" style="overflow-y: auto;">
    <div class="modal-dialog modal-fix-lg">
        <form action="" method="POST" novalidate>
            @csrf
            @method('PATCH')
            <input type="hidden" name="question_type" value="CTQ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Soal Melengkapi Tabel</h5>
                    <button class="close modal-close" data-dismiss="modal">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ckeditor-list">
                        <label for="keterangan-soal">Keterangan Soal</label>
                        <textarea name="keterangan_soal" class="editor-field" cols="30" rows="3" placeholder="Ketik keterangan soal"></textarea>
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
                        <div class="table-responsive">
                            <table class="melengkapi-tabel-input-table" data-type="melengkapi_tabel">

                            </table>
                        </div>
                        <a href="#" class="add-btn" id="add-btn" data-type="melengkapi_tabel"><i class="kejar-add"></i> <span>Tambah Jawaban</span></a>
                    </div>
                    <div class="form-group ckeditor-list">
                        <label for="keterangan-soal">Pembahasan</label>
                        <textarea name="pembahasan" class="editor-field" cols="30" rows="3" placeholder="Ketik pembahasan"></textarea>
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
                <div class="modal-footer">
                    <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>