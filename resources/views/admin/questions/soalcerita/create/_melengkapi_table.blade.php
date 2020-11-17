<div class="modal" id="create-melengkapi-tabel-column">
    <div class="modal-dialog modal-fix-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Soal Melengkapi Tabel</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <label for="">Jumlah Kolom</label>
                        <input type="number" name="column_amount" placeholder="Ketik jumlah kolom tabel" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" data-toggle="modal" data-target="#create-melengkapi-tabel" data-backdrop="static">Lanjut</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create-melengkapi-tabel">
    <div class="modal-dialog modal-fix-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Soal Melengkapi Tabel</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions') }}" method="POST" id="create-melengkapi-tabel-form">
                    @csrf
                    <input type="hidden" name="question_type" value="CTQ">
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
                                <tr>
                                    <td>
                                        <input type="text" placeholder="Ketik judul kolom" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="Ketik judul kolom" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="Ketik judul kolom" class="form-control">
                                    </td>
                                    <td>
                                        <button class="remove-btn"><i class="kejar-close"></i></button>
                                    </td>
                                </tr>
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
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" onclick="document.getElementById('create-melengkapi-tabel-form').submit();">Simpan</button>
            </div>
        </div>
    </div>
</div>
