<div class="modal fade modal-large" id="create-memasangkan">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="question_type" value="MQ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Soal Memasangkan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Keterangan Soal</label>
                        <textarea class="textarea-field ckeditor-field" name="question" placeholder="Ketik keterangan soal" required></textarea>
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
                        <label>Pasangan Pernyataan/Kalimat/Kata</label>
                        <p>Isi secara berpasangan. Pernyataan/kalimat/kata ditampilkan secara acak.</p>
                        <table class="answer-list-table-ps" data-type="memasangkan">
                            @for ($i = 0; $i < 3; $i++)
                            <tr>
                                <td>
                                    <div class="num-group">{{ $i + 1 }}</div>
                                </td>
                                <td>
                                    <div class="ckeditor-group ckeditor-list mb-3">
                                        <textarea name="answer[statement][{{ $i }}]" class="ckeditor-field" placeholder="Ketik pernyataan {{ $i + 1 }}" ck-type="memasangkan"></textarea>
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
                                    <div class="ckeditor-group ckeditor-list">
                                        <textarea name="answer[setstatement][{{ $i }}]" class="ckeditor-field" placeholder="Ketik pasangan pernyataan {{ $i + 1 }}" ck-type="memasangkan"></textarea>
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
                                    <button class="remove-btn" type="button">
                                        <i class="kejar-close"></i>
                                    </button>
                                </td>
                            </tr>
                            @endfor
                        </table>
                        <button class="btn btn-add border-0 pl-0 add-btn" type="button" data-type="memasangkan">
                            <i class="kejar-add"></i> Tambah Pasangan Pernyataan
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
