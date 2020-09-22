$('#upload-questions').on('show.bs.modal', event => {
    $('#create-question').modal('hide');
});

$(function () {
    $('[data-toggle="popover"]').popover();
});

$('#create-question').on('show.bs.modal', event => {
    $('#upload-questions').modal('hide');
});

$(document).on('click', '.btn-add', function(){
    var index = $('.table-form tbody tr').length;
    var type = $(this).attr('data-type');
    if (type == 'toeic') {
        $('.table-form').find('tbody').append('<tr><td><input type="text" placeholder="Ketik meaning" name="question[' + index + '][question]" class="form-control"></td><td><input type="text" placeholder="Ketik word" name="question['+ index +'][answer]" class="form-control"></td></tr>');
    } else {
        $('.table-form').find('tbody').append('<tr><td><input type="text" placeholder="Ketik soal" name="question[' + index + '][question]" class="form-control"></td><td><input type="text" placeholder="Ketik jawaban" name="question['+ index +'][answer]" class="form-control"></td></tr>');
    }
});

$(document).on('click', '.btn-add-alternative-answer', function(){
    var textAreaAnswer = $(this).prev().find('textarea');
    var textAreaNum = 0;
    textAreaAnswer.each(function(){
        $(this).attr('name', 'question[answer][' + textAreaNum + ']');
        $(this).attr('placeholder', 'Ketik alternatif jawaban '+ (textAreaNum + 1));
        textAreaNum++;
    });
    $(this).prev().append('<div class="d-flex justify-content-start align-items-start"><textarea class="textarea-answer" name="question[answer][' + textAreaNum + ']" cols="30" rows="3" placeholder="Ketik alternatif jawaban '+ (textAreaNum + 1) +'" required></textarea><button class="btn-delete-answer" type="button"><i class="kejar-close"></i></button></div>');
});

$(document).on('change', 'input[type=file]', function(){
    var filename = $(this).val().replace(/C:\\fakepath\\/i, '');

    filename = filename == '' ? 'Pilih file' : filename;
    $(this).parents('.custom-upload').find('input[type=text]').val(filename);
});

// Editing

$('.page-title h2').dblclick(function() {
    $('#rename-round').modal('show');
});

$('.description').dblclick(function() {
    $('#update-description').modal('show');
});

$('.setting').dblclick(function() {
    $('#update-setting').modal('show');
});

$('.material').dblclick(function() {
    $('#update-material').modal('show');
});

$('.direction').dblclick(function() {
    $('#update-direction').modal('show');
});

$('.table-questions tbody tr, .table-toeic tbody tr').on('dblclick', 'td', function() {
    var modal = $('#update-question');
    var id = $(this).parent().data('id');
    var question = $(this).parent().data('question');
    var answer = $(this).parent().data('answer');
    var url = $(this).parent().data('url');
    $(modal).find('form').attr('action', url);
    $(modal).find('input[name="question"]').val(question);
    $(modal).find('input[name="answer"]').val(answer);
    $(modal).modal('show');
});

$('.copy-id').click(function (e) { 
    e.preventDefault();
    textToClipboard($(this).data('id'));
});

function textToClipboard (text) {
    event.preventDefault();
    setTimeout(() => {
        $('[data-toggle="popover"]').popover('hide');
    }, 1000);
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
}

$(document).on('click', '.ckeditor-btn-1 .bold-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(0)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .italic-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(1)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .underline-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(2)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .bullet-list-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(3)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .number-list-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(4)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .photo-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items span button').click();
});

$(document).on('click', '.ck-content p, .ck-content ul li, .ck-content ol li', function(){
    checkActive();
});

$(document).keydown(function(e){
    checkActive();
});

function checkActive(){
    $('.ckeditor-btn-1').each(function(){
        var ckeditorBtnGroup = $(this);
        var ckeditorDiv = ckeditorBtnGroup.prev();

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(0)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.bold-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.bold-btn').removeClass('active');
        }

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(1)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.italic-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.italic-btn').removeClass('active');
        }

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(2)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.underline-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.underline-btn').removeClass('active');
        }

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(3)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.bullet-list-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.bullet-list-btn').removeClass('active');
        }

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(4)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.number-list-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.number-list-btn').removeClass('active');
        }

    });
}

$(document).on('click', '.btn-delete-answer', function(){
    var thisParent1 = $(this).parent();
    var thisParent2 = thisParent1.parent();
    thisParent1.remove();
    var textAreaAnswer = thisParent2.find('textarea');
    var textAreaNum = 0;
    textAreaAnswer.each(function(){
        $(this).attr('name', 'question[answer][' + textAreaNum + ']');
        $(this).attr('placeholder', 'Ketik alternatif jawaban '+ (textAreaNum + 1));
        textAreaNum++;
    });
});

ClassicEditor
.create( document.querySelector( '#create_editor' ), {
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

let updateEditor;

ClassicEditor
.create( document.querySelector( '#update_editor' ), {
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
    updateEditor = editor;
} )
.catch( error => {
    console.error( 'Oops, something went wrong!' );
    console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
    console.warn( 'Build id: nekgv7mmfgzn-cehsg6b07p1b' );
    console.error( error );
} );

$(document).on('dblclick', '.question-list-item', function(){
    var url = $(this).attr('data-url');
    $.ajax({
        method: "GET",
        url: url,
        success:function(response){
            var editModal = $('#update-menulis-efektif-question-modal');
            editModal.find('.textarea-question').text(response.question);
            editModal.find('form').attr('action', url);
            var answerTextArea = '';
            for (var i = 0; i < response.answer.length; i++) {
                if (i == 0) {
                    answerTextArea += '<textarea class="textarea-answer" name="question[answer][' + i + ']" id="answer" cols="30" rows="3" placeholder="Ketik alternatif jawaban '+ (i + 1) +'" required>'+ response.answer[i] +'</textarea>';  
                } else {
                    answerTextArea += '<div class="d-flex justify-content-start align-items-start"><textarea class="textarea-answer" name="question[answer][' + i + ']" cols="30" rows="3" placeholder="Ketik alternatif jawaban '+ (i + 1) +'" required>'+ response.answer[i] +'</textarea><button class="btn-delete-answer" type="button"><i class="kejar-close"></i></button></div>';
                }
            }
            editModal.find('.new_answer').html(answerTextArea);
            updateEditor.setData(response.explanation ?? '<p class="ck-placeholder" data-placeholder="Ketik Pembahasan"><br data-cke-filler="true"></p>');
            editModal.modal('show');
        }
    });
});

var editorArray = [];

function generateEditor(index, element) {
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
        editorArray[index] = editor;
    } )
    .catch( error => {
        console.error( 'Oops, something went wrong!' );
        console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
        console.warn( 'Build id: nekgv7mmfgzn-cehsg6b07p1b' );
        console.error( error );
    } );

}

$('#update-material').on('show.bs.modal', (e) => {
    generateEditor(0, $(e.target).find('textarea')[0]);
});

$('#update-material').on('hide.bs.modal', (e) => {
    clearTheEditors();
});

function clearTheEditors() {
    for (let index = 0; index < editorArray.length; index++) {
        editorArray[index].destroy();
    }

    editorArray = [];
}

$('#create-menulis-efektif-question-modal').on('show.bs.modal', (e) => {
    $(e.target).find('.textarea-question').each((index, element) => {
        generateEditor(index, element);
    });
});

$('#create-menulis-efektif-question-modal').on('hide.bs.modal', (e) => {
    clearTheEditors();
});

$('#update-menulis-efektif-question-modal').on('show.bs.modal', (e) => {
    $(e.target).find('.textarea-question').each((index, element) => {
        generateEditor(index, element);
    });
});

$('#update-menulis-efektif-question-modal').on('hide.bs.modal', (e) => {
    clearTheEditors();
});