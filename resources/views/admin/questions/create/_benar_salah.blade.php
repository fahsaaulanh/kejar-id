<div class="modal fade" id="create-benar-salah">
    <div class="modal-dialog modal-fix">
        <form action="{{ url('/admin/'. $game['uri'] . '/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions') }}" method="POST" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Soal Benar Salah</h5>
                    <button class="close modal-close" data-dismiss="modal">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="question_type" value="TFQMA">
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
                        <table class="benar-salah-input-table" data-type="benar_salah">
                            <tr>
                                <td>
                                    <div class="ckeditor-list">
                                        <textarea name="pertanyaan[]" class="editor-field" placeholder="Ketik pernyataan 1"></textarea>
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
                                    <input type="hidden" name="status_pertanyaan[]">
                                    <div class="dropdown custom-dropdown">
                                        <button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="dropdown-status">
                                                B/S
                                            </span>
                                            <i class="kejar-dropdown"></i>
                                        </button>
                                        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Benar</a>
                                            <a class="dropdown-item" href="#">Salah</a>
                                        </div>
                                    </div>
                                    <button class="remove-btn"><i class="kejar-close"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ckeditor-list">
                                        <textarea name="pertanyaan[]" cols="30" rows="1" class="editor-field" placeholder="Ketik pernyataan 2"></textarea>
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
                                    <input type="hidden" name="status_pertanyaan[]">
                                    <div class="dropdown custom-dropdown">
                                        <button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="dropdown-status">
                                                B/S
                                            </span>
                                            <i class="kejar-dropdown"></i>
                                        </button>
                                        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Benar</a>
                                            <a class="dropdown-item" href="#">Salah</a>
                                        </div>
                                    </div>
                                    <button class="remove-btn"><i class="kejar-close"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ckeditor-list">
                                        <textarea name="pertanyaan[]" cols="30" rows="1" class="editor-field" placeholder="Ketik pernyataan 3"></textarea>
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
                                    <input type="hidden" name="status_pertanyaan[]">
                                    <div class="dropdown custom-dropdown">
                                        <button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="dropdown-status">
                                                B/S
                                            </span>
                                            <i class="kejar-dropdown"></i>
                                        </button>
                                        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Benar</a>
                                            <a class="dropdown-item" href="#">Salah</a>
                                        </div>
                                    </div>
                                    <button class="remove-btn"><i class="kejar-close"></i></button>
                                </td>
                            </tr>
                        </table>
                        <a href="#" class="add-btn" id="add-btn" data-type="benar_salah"><i class="kejar-add"></i> <span>Tambah Pernyataan</span></a>
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
                </div>
                <div class="modal-footer">
                    <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>