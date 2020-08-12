<!-- Modal -->
<div class="modal fade" id="create-menulis-efektif-question-modal" tabindex="-1" role="dialog" aria-labelledby="create-menulis-efektif-question-modal" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions') }}" method="post" id="question-create-form"    >
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Soal</label>
                        <textarea type="text" style="resize: none; height: 6rem;" name="question[question]" placeholder="Ketik soal" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="answer">Jawaban</label>
                        <p>Semua alternatif jawaban dianggap benar.</p>
                        <div id="new_answer">
                            <textarea type="text" style="resize: none; height: 6rem;" name="question[answer][0]" id="answer" cols="30" rows="3" placeholder="Ketik alternatif jawaban 1"></textarea><hr class="border-0">
                        </div>
                        <button class="btn btn-add border-0" id="btn-add-alternative-answer" type="button">
                            <i class="kejar-add"></i> Tambah alternatif jawaban
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="discussion">Pembahasan</label>
                        <textarea name="question[explanation]" id="summary-ckeditor" cols="30" rows="3" placeholder="Ketik Pembahasan"></textarea>
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
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
CKEDITOR.replace( 'summary-ckeditor' );
</script>