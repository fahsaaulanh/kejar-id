<!-- Modal -->
<div class="modal fade" id="update-wacana" tabindex="-1" role="dialog" aria-labelledby="update-wacana" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id']) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Wancana</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-groupp ck-height-9 ckeditor-list">
                        <label for="wacana">Wancana</label>
                        <textarea name="wacana" class="editor-field" id="wacana" rows="4" cols="200" placeholder="Masukkan wacana">{!! $unit['material'] === 'NULL' ? '' : $unit['material'] !!}</textarea>
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