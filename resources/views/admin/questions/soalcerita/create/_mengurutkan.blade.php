@extends('layout.index')

@section('title', 'Selamat datang!')

@section('header')
@endsection

@section('content')
<div class="modal fade modal-large" id="create-mengurutkan">
    <div class="modal-dialog" role="document">
        <form action="{{ url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions') }}" method="POST">
            @csrf
            <input type="hidden" name="question_type" value="SSQ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Soal Mengurutkan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Keterangan Soal</label>
                        <textarea class="editor-field" id="ur_question_field" name="question[question]" placeholder="Ketik keterangan soal"></textarea>
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
                        <label>Pernyataan/Kalimat</label>
                        <p>Isi dengan berurutan. Pernyataan/kalimat akan ditampilkan secara acak.</p>
                        <table class="answer-list-table-ur mengurutkan-input-table" data-type="mengurutkan">
                            @for ($i = 0; $i < 3; $i++)
                            <tr>
                                <td>
                                    <div class="num-group">
                                        <input type="hidden" name="answer[{{ $i }}][key]" value="{{ $i + 1 }}">
                                        {{ $i + 1 }}
                                    </div>
                                </td>
                                <td>
                                    <div class="ckeditor-group ckeditor-list">
                                        <textarea name="answer[{{ $i }}][description]" class="editor-field" placeholder="Ketik pernyataan/kalimat urutan {{ $i + 1 }}" ck-type="mengurutkan"></textarea>
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
                                    <div class="btn-action-group">
                                        <div class="dropdown dropleft">
                                            <button class="sort-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="kejar-drag-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"><i class="kejar-top"></i> Geser ke Atas</a>
                                                <a class="dropdown-item" href="#"><i class="kejar-bottom"></i> Geser ke Bawah</a>
                                            </div>
                                        </div>
                                        <button class="remove-btn" type="button">
                                            <i class="kejar-close"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endfor
                        </table>
                        <button class="btn btn-add border-0 pl-0 add-btn" type="button" data-type="mengurutkan">
                            <i class="kejar-add"></i> Tambah Pernyataan/Kalimat
                        </button>
                    </div>
                    <div class="form-group ck-height-9 ckeditor-list">
                        <label>Pembahasan</label>
                        <textarea class="editor-field" id="ur_description_field" name="question[description]" placeholder="Ketik pembahasan"></textarea>
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
@endsection

@push('script')
<script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
<script src="{{ mix('/js/admin/question/script.js') }}"></script>
<script>
    $('#create-mengurutkan').modal('show');

    initalizeEditor(0, $('#ur_question_field')[0]);
    initalizeEditor(0, $('#ur_description_field')[0]);
    initalizeCkEditorUr();
    sortBtnManagement();

    var ckEditorDataUr = [];

    function initalizeEditor(index, element) {
        ClassicEditor
        .create( element, {
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
            if ($(element).attr('ck-type') == 'mengurutkan') {
                ckEditorDataUr[index] = editor;
            }
        } )
        .catch( error => {
            console.error( 'Oops, something went wrong!' );
            console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
            console.warn( 'Build id: nekgv7mmfgzn-cehsg6b07p1b' );
            console.error( error );
        } );
        
    }

    function initalizeCkEditorUr() {
        $('.editor-field').each(function(index, element){
            initalizeEditor(index, element);
        });
    }

    function sortBtnManagement(){
        $('.answer-list-table-ur tr').each(function(){
            $(this).find('.dropdown-item').removeClass('d-none');
        });
        $('.answer-list-table-ur tr').first().find('.dropdown-item:nth-child(1)').addClass('d-none');
        $('.answer-list-table-ur tr').last().find('.dropdown-item:nth-child(2)').addClass('d-none');
    }
</script>
@endpush