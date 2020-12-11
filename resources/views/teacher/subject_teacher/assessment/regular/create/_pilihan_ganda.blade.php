<div class="modal fade" id="create-pilihan-ganda">
    <div class="modal-dialog  modal-fix" role="document">
    @if(count($assessments) > 0)
        <form onsubmit="event.preventDefault(); saveQuestion('{{$assessmentGroupId}}', '{{$subject['id']}}', '{{$grade}}', '{{$assessments[0]['id']}}')">
    @else
        <form onsubmit="event.preventDefault(); saveQuestion('{{$assessmentGroupId}}', '{{$subject['id']}}', '{{$grade}}', '')">
    @endif
            @csrf
            <input type="hidden" name="question_type" value="MCQSA">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Soal Pilihan Ganda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Soal</label>
                        <textarea id="question" class="textarea-field ckeditor-field" name="question" placeholder="Ketik soal" required></textarea>
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
                        <label>Jawaban</label>
                        <p>Pilih satu jawaban benar.</p>
                        <table class="answer-list-table-pg" data-type="pilihan-ganda" id="table_add_answer">
                            @for ($i = 0; $i < 4; $i++)
                            <tr>
                                <td>
                                    <div class="radio-group">
                                        <input type="radio" name="cr_answer" value={{ $i }} @if($i === 0) required @endif>
                                        <i class="kejar-belum-dikerjakan"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="ckeditor-group ckeditor-list">
                                        <textarea name="choices" class="ckeditor-field" placeholder="Ketik pilihan jawaban {{ $i + 1 }}" ck-type="pilihan-ganda" required></textarea>
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
                                </td>
                                <td>
                                    <button class="remove-btn" type="button" onclick="removeChoice(event, 'addplus')">
                                        <i class="kejar-close"></i>
                                    </button>
                                </td>
                            </tr>
                            @endfor
                        </table>
                        <button id="addplus" class="btn btn-add border-0 pl-0 add-btn" type="button" data-type="pilihan-ganda" onclick="addChoice(event, 'table_add_answer')">
                            <i class="kejar-add"></i> Tambah Pilihan Jawaban
                        </button>
                    </div>
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Pembahasan</label>
                        <textarea id="explanation" class="textarea-field ckeditor-field" name="explanation" placeholder="Ketik pembahasan"></textarea>
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
                    <div class="text-right col-md-12">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <div class="col-12 text-center mt-3" id="LoadingAssess1" style="display:none">
                        <div class="row justify-content-center">
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Menyimpan...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Menyimpan...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Menyimpan...</span>
                            </div>
                        </div>
                        <div class="mt-2 row justify-content-center">
                            <h5>Sedang Menyimpan</h5>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
