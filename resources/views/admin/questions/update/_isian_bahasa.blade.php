<!-- Modal -->
<div class="modal fade" id="update-menulis-efektif-question-modal" tabindex="-1" role="dialog" aria-labelledby="create-menulis-efektif-question-modal" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-fix" role="document">
        <form method="post">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ck-height-9">
                        <label for="title">Soal</label>
                        <textarea class="textarea-question" name="question[question]" placeholder="Ketik soal" required></textarea>
                        <div class="ckeditor-btn-group ckeditor-btn-1">
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
                        <label>Jawaban</label>
                        <p>Semua alternatif jawaban dianggap benar.</p>
                        <table class="answer-list-table-me" data-type="menulis-efektif">
                            <colgroup>
                                <col class="first-col"/>
                                <col class="second-col"/>
                            </colgroup>
                        </table>
                        <button class="btn btn-add border-0 pl-0" type="button" data-type="menulis-efektif">
                            <i class="kejar-add"></i> Tambah alternatif jawaban
                        </button>
                    </div>
                    <div class="form-group ck-height-9">
                        <label>Pembahasan</label>
                        <textarea class="textarea-question" name="question[explanation]" cols="30" rows="3" placeholder="Ketik Pembahasan" ck-type="update-menulis-efektif"></textarea>
                        <div class="ckeditor-btn-group ckeditor-btn-1">
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
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>