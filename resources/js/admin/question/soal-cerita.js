const { bind } = require("lodash");
const { ajax, ajaxSetup } = require("jquery");

$('#upload-questions').on('show.bs.modal', event => {
    $('#create-question').modal('hide');
});

$(function () {
    $('[data-toggle="popover"]').popover();
});

$('#create-question').on('show.bs.modal', event => {
    $('#upload-questions').modal('hide');
});

$(document).on('change', 'input[type=file]', function(){
    var filename = $(this).val().replace(/C:\\fakepath\\/i, '');

    filename = filename == '' ? 'Pilih file' : filename;
    $(this).parents('.custom-upload').find('input[type=text]').val(filename);
});

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

$(document).on('mousedown', '.ckeditor-list .bold-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .italic-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .underline-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .bullet-list-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .number-list-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .photo-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('input', '.answer-list-table-pg input[type=radio]', function() {
    radioPgManagement();
});

$(document).on('focus', '.ckeditor-list .ck-content', function(){
    $(this).parents().closest('.ck-editor').next().removeClass('d-none');
}).on('blur', '.ckeditor-list .ck-content', function(){
    $(this).parents().closest('.ck-editor').next().addClass('d-none');
});

$(document).on('click', '.add-btn', function(){
    var type = $(this).attr('data-type');
    if (type == 'pilihan-ganda'){
        var thisModal = $(this).parents('.modal');
        var totalField = thisModal.find('.answer-list-table-pg tr').length;
        if (totalField < 10) {
            if (totalField == 2) {
                thisModal.find('.answer-list-table-pg tr').each(function(){
                    var secondField = $(this).children().eq(1);
                    var removeBtn = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
                    secondField.attr('colspan', 1);
                    secondField.removeClass('colspan-2');
                    $(this).append(removeBtn);
                });
            }
            var td1 = '<td><div class="radio-group"><input type="radio" name="answer" value="'+ totalField +'"><i class="kejar-belum-dikerjakan"></i></div></td>';
            var td2 = '<td><div class="ckeditor-group ckeditor-list"><textarea name="choices['+ totalField +']" class="ckeditor-field" placeholder="Ketik pilihan jawaban '+ parseInt(totalField + 1) +'" ck-type="pilihan-ganda" required></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
            var td3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
            var newAnswer = '<tr>'+ td1 + td2 + td3 +'</tr>';
            thisModal.find('.answer-list-table-pg').append(newAnswer);
            initializeEditor(ckEditorFieldLength, $(this).prev().children().find('.ckeditor-field').last()[0]);
        }
        radioPgManagement();
    }
});

$(document).on('click', '.edit-btn', function(){
    var type = $(this).data('target');
    var modal = $(type);
    var url = $(this).data('url');
    if (type == '#edit-pilihan-ganda') {
        $.ajax({
            url: url,
            method: "GET",
            success:function(response){
                modal.find('form').attr('action', url);
                modal.find('textarea[name=question]').val(response.question);
                modal.find('textarea[name=explanation]').val(response.explanation);
                var answersData = '';
                for (var i = 0; i < Object.keys(response.choices).length; i++) {
                    var checkedRadio = response.answer == String.fromCharCode(parseInt(65 + i)) ? 'checked' : '';
                    if (Object.keys(response.choices).length > 2) {
                        answersData += '<tr><td><div class="radio-group"><input type="radio" name="answer" value="'+ i +'" '+ checkedRadio +'><i class="kejar-belum-dikerjakan"></i></div></td><td><div class="ckeditor-group ckeditor-list"><textarea name="choices['+ i +']" class="ckeditor-field" placeholder="Ketik pilihan jawaban '+ parseInt(i + 1) +'" ck-type="pilihan-ganda" required>'+ response.choices[String.fromCharCode(parseInt(65 + i))] +'</textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td></tr>';
                    } else {
                        answersData += '<tr><td><div class="radio-group"><input type="radio" name="answer" value="'+ i +'" '+ checkedRadio +'><i class="kejar-belum-dikerjakan"></i></div></td><td colspan="2" class="colspan-2"><div class="ckeditor-group ckeditor-list"><textarea name="choices['+ i +']" class="ckeditor-field" placeholder="Ketik pilihan jawaban '+ parseInt(i + 1) +'" ck-type="pilihan-ganda" required>'+ response.choices[String.fromCharCode(parseInt(65 + i))] +'</textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td></tr>';
                    }
                }
                modal.find('.answer-list-table-pg').html(answersData);
                modal.find('.ckeditor-field').each((index, element) => {
                    initializeEditor(index, element);
                });
                setTimeout(function(){ radioPgManagement(); }, 50);
                modal.modal('show');
            }
        });
    }
});

$(document).on('click', '.remove-btn', function(){
    var type = $(this).parents('table').attr('data-type');
    if (type == 'pilihan-ganda') {
        var thisModal = $(this).parents('.modal');
        $(this).parents('tr').remove();
        clearEditorField();
        thisModal.find('.ckeditor-field').each((index, element) => {
            initializeEditor(index, element);
        });
        var number = 0;
        thisModal.find('.answer-list-table-pg tr').each(function(){
            $(this).find('input[type=radio]').val(number);
            $(this).find('textarea').attr({
                'name': 'choices['+ number +']',
                'placeholder': 'Ketik pilihan jawaban ' + parseInt(number + 1)
            });
            number++;
        });
        var totalField = thisModal.find('.answer-list-table-pg tr').length;
        if (totalField == 2) {
            thisModal.find('.answer-list-table-pg tr').each(function(){
                var secondField = $(this).children().eq(1);
                secondField.attr('colspan', 2);
                secondField.addClass('colspan-2');
                $(this).children().eq(2).remove();
            });
        }
        setTimeout(function(){ radioPgManagement(); }, 50);
    }
});

$('#create-pilihan-ganda').on('show.bs.modal', (e) => {
    e.stopImmediatePropagation();
    $('#create-soal-cerita-question-modal').modal('hide');
    $(e.target).find('.ckeditor-field').each((index, element) => {
        initializeEditor(index, element);
    });
});

$('.modal').on('hide.bs.modal', (e) => {
    clearEditorField();
});

function radioPgManagement(){
    $('.answer-list-table-pg input[type=radio]').each(function(){
        if ($(this).is(':checked')) {
            $(this).parents().closest('td').next().find('.ck-editor').addClass('active');
        } else {
            $(this).parents().closest('td').next().find('.ck-editor').removeClass('active');
        }   
    });
}

var ckEditorField = [];
var ckEditorFieldLength = 0;

function initializeEditor(index, element) {
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
        ckEditorField[index] = editor;
    } )
    .catch( error => {
        console.error( 'Oops, something went wrong!' );
        console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
        console.warn( 'Build id: nekgv7mmfgzn-cehsg6b07p1b' );
        console.error( error );
    } );
    ckEditorFieldLength++;
}

function clearEditorField() {
    for (let index = 0; index < ckEditorField.length; index++) {
        ckEditorField[index].destroy();
    }
    
    ckEditorField = [];
    ckEditorFieldLength = 0;
}