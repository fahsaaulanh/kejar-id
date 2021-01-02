<div class="modal fade" id="update-pilihan-ganda">
    <div class="modal-dialog modal-fix" role="document">
        <form action="" method="POST" novalidate>
            @csrf
            @method('PATCH')
            <input type="hidden" name="question_type" value="MCQSA">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Soal Pilihan Ganda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ck-height-9 ckeditor-list">
                        <h5>Soal</h5>
                        <div class="pb-2"><h6-reg class="text-grey-3">Tidak perlu menginputkan nomor soal.</h6-reg></div>
                        <textarea class="textarea-field editor-field" name="question" placeholder="Ketik soal" required></textarea>
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
                            <button type="button" class="message-btn-update" title="Masukkan foto">
                                <i class="kejar-photo"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <h5>Jawaban</h5>
                        <div class="pb-2"><h6-reg class="text-grey-3">Tidak perlu menginputkan A, B, C pilihan jawaban dan pilih satu jawaban benar.</h6-reg></div>
                        <table class="answer-list-table-pg" data-type="pilihan-ganda">

                        </table>
                        <button class="btn btn-add border-0 pl-0 add-btn" type="button" data-type="pilihan-ganda">
                            <i class="kejar-add"></i> Tambah Pilihan Jawaban
                        </button>
                    </div>
                    <div class="form-group ck-height-9 ckeditor-list">
                        <div class="pb-2"><h5>Pembahasan</h5></div>
                        <textarea class="textarea-field editor-field" name="explanation" placeholder="Ketik pembahasan"></textarea>
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
                            <button type="button" class="message-btn-update" title="Masukkan foto">
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