<div class="modal fade modal-large" id="edit-teks-rumpang-pg">
    <div class="modal-dialog" role="document">
        <form method="POST" novalidate>
            @csrf
            @method('PATCH')
            <input type="hidden" name="question_type" value="IQ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Soal Teks Rumpang PG</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Teks Soal</label>
                        <textarea class="textarea-field ckeditor-field" name="question" placeholder="Ketik soal" required></textarea>
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
                    <div class="form-group bagian-rumpang first-rumpang">
                        <label>Jawaban</label>
                        <p>Semua alternatif jawaban dianggap benar.</p>
                        <table class="answer-list-table-rmpg" data-type="tabel-rumpang-pg"></table>
                        <button class="btn btn-add border-0 pl-0 add-btn" type="button" data-type="jawaban-rumpang-pg">
                            <i class="kejar-add"></i> Tambah Pilihan Jawaban
                        </button>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-add lg add-btn" type="button" data-type="next-rumpang-pg">
                            <i class="kejar-add"></i> Tambah Lanjutan Teks
                        </button>
                    </div>
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Pembahasan</label>
                        <textarea class="textarea-field ckeditor-field" name="explanation" placeholder="Ketik pembahasan"></textarea>
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
