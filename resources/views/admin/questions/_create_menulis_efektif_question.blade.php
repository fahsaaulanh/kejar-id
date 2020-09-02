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
                        <textarea class="textarea-question" name="question[question]" placeholder="Ketik soal" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="answer">Jawaban</label>
                        <p>Semua alternatif jawaban dianggap benar.</p>
                        <div id="new_answer">
                            <textarea class="textarea-answer" name="question[answer][0]" id="answer" cols="30" rows="3" placeholder="Ketik alternatif jawaban 1"></textarea>
                        </div>
                        <button class="btn btn-add border-0" id="btn-add-alternative-answer" type="button">
                            <i class="kejar-add"></i> Tambah alternatif jawaban
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="discussion">Pembahasan</label>
                        <textarea name="question[explanation]" id="editor" cols="30" rows="3" placeholder="Ketik Pembahasan"></textarea>
                        <div class="ckeditor-btn-group">
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
<script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            toolbar: {
                items: [
                    'bold',
                    'italic',
                    'underline',
                    'bulletedList',
                    'numberedList',
                    'imageUpload'
                ]
            },
            language: 'en',
            image: {
                styles: [
                    'alignLeft', 'alignCenter', 'alignRight'
                ],
                resizeOptions: [
                    {
                        name: 'imageResize:original',
                        label: 'Original',
                        value: null
                    },
                    {
                        name: 'imageResize:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'imageResize:75',
                        label: '75%',
                        value: '75'
                    }
                ],
                toolbar: [
                    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                    '|',
                    'imageResize',
                ],
            },
            licenseKey: '',
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( error => {
            console.error( 'Oops, something went wrong!' );
            console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
            console.warn( 'Build id: nekgv7mmfgzn-cehsg6b07p1b' );
            console.error( error );
        } );
</script>