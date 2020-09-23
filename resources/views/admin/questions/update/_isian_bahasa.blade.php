<!-- Modal -->
<div class="modal fade" id="update-menulis-efektif-question-modal" tabindex="-1" role="dialog" aria-labelledby="create-menulis-efektif-question-modal" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form method="post" id="question-create-form">
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
                    <div class="form-group">
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
                        <label for="answer">Jawaban</label>
                        <p>Semua alternatif jawaban dianggap benar.</p>
                        <div class="new_answer">
                            <textarea class="textarea-answer" name="question[answer][0]" id="answer" cols="30" rows="3" placeholder="Ketik alternatif jawaban 1" required></textarea>
                        </div>
                        <button class="btn btn-add border-0 btn-add-alternative-answer" type="button">
                            <i class="kejar-add"></i> Tambah alternatif jawaban
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="discussion">Pembahasan</label>
                        <textarea name="question[explanation]" id="update_editor" cols="30" rows="3" placeholder="Ketik Pembahasan"></textarea>
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