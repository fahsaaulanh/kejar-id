<div class="modal" id="create-ya-tidak">
    <div class="modal-dialog modal-fix">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Soal Ya Tidak</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions') }}" method="POST" id="create-ya-tidak-form">
                    @csrf
                    <input type="hidden" name="question_type" value="YNQMA">
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
                        <label for="pertanyaan">Pernyataan</label>
                        <p>Pilih benar atau salah untuk setiap pernyataan.</p>
                        <table class="ya-tidak-input-table" data-type="ya_tidak">
                            @for ($x = 0; $x < 3; $x++)
                            <tr>
                                <td>
                                    <div class="ckeditor-list">
                                        <textarea name="question[]" class="editor-field" placeholder="Ketik pernyataan {{$x + 1}}"></textarea>
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
                                    <input type="hidden" name="answer[]">
                                    <div class="dropdown custom-dropdown">
                                        <button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="dropdown-status">
                                                Y/T
                                            </span>
                                            <i class="kejar-dropdown"></i>
                                        </button>
                                        <div class="dropdown-menu w-100" aria-labelledby="">
                                            <a class="dropdown-item" href="#">Ya</a>
                                            <a class="dropdown-item" href="#">Tidak</a>
                                        </div>
                                    </div>
                                    <button class="remove-btn"><i class="kejar-close"></i></button>
                                </td>
                            </tr>
                            @endfor
                        </table>
                        <a href="#" class="add-btn" id="add-btn" data-type="ya_tidak"><i class="kejar-add"></i> <span>Tambah Pernyataan</span></a>
                    </div>
                    <div class="form-group ckeditor-list">
                        <label for="keterangan-soal">Pembahasan</label>
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
                <button class="btn btn-primary" onclick="document.getElementById('create-ya-tidak-form').submit();">Simpan</button>
            </div>
        </div>
    </div>
</div>
