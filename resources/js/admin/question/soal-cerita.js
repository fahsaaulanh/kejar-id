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

// $(document).on('click', '.btn-add', function(){
//     var index = $('.table-form tbody tr').length;

//     $('.table-form').find('tbody').append('<tr><td><input type="text" placeholder="Ketik soal" name="question[' + index + '][question]" class="form-control"></td><td><input type="text" placeholder="Ketik jawaban" name="question['+ index +'][answer]" class="form-control"></td></tr>');
// });

$(document).on('click', '#btn-add-alternative-answer', function(){
    var index = $('.form-group #new_answer textarea').length;
    $('#new_answer').append('<div class="d-flex justify-content-start align-items-start"><textarea class="textarea-answer" name="question[answer][' + index + ']" id="answer" cols="30" rows="3" placeholder="Ketik alternatif jawaban '+ (index+1) +'"></textarea><button class="btn-delete-answer" type="button"><i class="kejar-close"></i></button></div>');
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

$('.table-questions tbody tr').on('dblclick', 'td', function() {
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

$(document).on('input', '.answer-list-table-md input[type=checkbox]', function() {
    checkBoxMdManagement('check');
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

    if (type == 'menceklis-daftar'){
        var modal = $(this).parents('.modal');
        var totalField = modal.find('.answer-list-table-md tr').length;
        if (totalField == 2) {
            modal.find('.answer-list-table-md tr').each(function(){
                var secondField = $(this).children().eq(1);
                var removeBtn = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
                secondField.attr('colspan', 1);
                secondField.removeClass('colspan-2');
                $(this).append(removeBtn);
            });
        }
        var td1 = '<td><div class="check-group"><input type="checkbox" name="answer[]" value="'+ totalField +'"><i class="kejar-belum-dikerjakan"></i></div></td>';
        var td2 = '<td><div class="ckeditor-group ckeditor-list"><textarea name="choices['+ totalField +']" class="editor-field ckeditor-field" placeholder="Ketik pilihan jawaban '+ parseInt(totalField + 1) +'" ck-type="menceklis-daftar" required></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
        var td3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
        var newAnswer = '<tr>'+ td1 + td2 + td3 +'</tr>';
        modal.find('.answer-list-table-md').append(newAnswer);
        initializeEditor(ckEditorFieldLength, $(this).prev().children().find('.editor-field').last()[0]);
        checkBoxMdManagement('check');
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

    if (type == '#edit-menceklis-daftar') {
        $.ajax({
            url: url,
            method: "GET",
            success:function(response){
                modal.find('form').attr('action', url);
                modal.find('textarea[name=question]').val(response.question);
                modal.find('textarea[name=explanation]').val(response.explanation);
                var answersData = '';
                for (var i = 0; i < Object.keys(response.choices).length; i++) {
                    var checkedBox = response.answer.includes(String.fromCharCode(parseInt(65 + i))) == true ? 'checked' : '';
                    if (Object.keys(response.choices).length > 2) {
                        answersData += '<tr><td><div class="check-group"><input type="checkbox" name="answer[]" value="'+ i +'" '+ checkedBox +'><i class="kejar-belum-dikerjakan"></i></div></td><td><div class="ckeditor-group ckeditor-list"><textarea name="choices['+ i +']" class="editor-field ckeditor-field" placeholder="Ketik pilihan jawaban '+ parseInt(i + 1) +' }}" ck-type="menceklis-daftar" required>'+ response.choices[String.fromCharCode(parseInt(65 + i))] +'</textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td></tr>';
                    } else {
                        answersData += '<tr><td><div class="check-group"><input type="checkbox" name="answer[]" value="'+ i +'" '+ checkedBox +'><i class="kejar-belum-dikerjakan"></i></div></td><td colspan="2" class="colspan-2"><div class="ckeditor-group ckeditor-list"><textarea name="choices['+ i +']" class="editor-field ckeditor-field" placeholder="Ketik pilihan jawaban '+ parseInt(i + 1) +' }}" ck-type="menceklis-daftar" required>'+ response.choices[String.fromCharCode(parseInt(65 + i))] +'</textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td></tr>';
                    }
                }
                modal.find('.answer-list-table-md').html(answersData);
                modal.find('.ckeditor-field').each((index, element) => {
                    initializeEditor(index, element);
                });
                setTimeout(function(){ checkBoxMdManagement('check'); }, 50);
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

    if (type == 'menceklis-daftar') {
        var modal = $(this).parents('.modal');
        $(this).parents('tr').remove();
        clearEditorField();
        modal.find('.ckeditor-field').each((index, element) => {
            initializeEditor(index, element);
        });
        var number = 0;
        modal.find('.answer-list-table-md tr').each(function(){
            $(this).find('input[type=checkbox]').val(number);
            $(this).find('textarea').attr({
                'name': 'choices['+ number +']',
                'placeholder': 'Ketik pilihan jawaban ' + parseInt(number + 1)
            });
            number++;
        });
        var totalField = modal.find('.answer-list-table-md tr').length;
        if (totalField == 2) {
            modal.find('.answer-list-table-md tr').each(function(){
                var secondField = $(this).children().eq(1);
                secondField.attr('colspan', 2);
                secondField.addClass('colspan-2');
                $(this).children().eq(2).remove();
            });
        }
        setTimeout(function(){ checkBoxMdManagement('check'); }, 50);
    }
});

$('#create-menceklis-daftar').on('show.bs.modal', (e) => {
    e.stopImmediatePropagation();
    $('#create-soal-cerita-question-modal').modal('hide');
    $(e.target).find('.ckeditor-field').each((index, element) => {
        initializeEditor(index, element);
    });
});

$('.modal').on('hide.bs.modal', (e) => {
    clearEditorField();
    checkBoxMdManagement('unchecked');
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

$(document).on('input', 'input[type=radio]', function() {
    $('.answer-list-table-pg .ck-editor').each(function(){
        $(this).removeClass('active');
    });
    $(this).parents().closest('td').next().find('.ck-editor').addClass('active');
});

// $(document).on('click', '.remove-btn', function(){
//     $(this).parents().closest('tr').remove();
//     var totalField = $('.answer-list-table-pg tr').length;
//     resetFieldPg();
//     refreshCkEditor();
//     if (totalField == 2) {
//         $('.answer-list-table-pg tr').each(function(){
//             var secondField = $(this).children().eq(1);
//             secondField.attr('colspan', 2);
//             secondField.addClass('colspan-2');
//             $(this).children().eq(2).remove();
//         });
//     }
// });

$(document).on('click', '#btn-add-answer-pg', function(){
    var totalField = $('.answer-list-table-pg tr').length;
    if (totalField < 10) {
        if (totalField == 2) {
            $('.answer-list-table-pg tr').each(function(){
                var secondField = $(this).children().eq(1);
                var removeBtn = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
                secondField.attr('colspan', 1);
                secondField.removeClass('colspan-2');
                $(this).append(removeBtn);
            });
        }
        var number = resetFieldPg();
        var td1 = '<td><div class="radio-group"><input type="radio" name="answer[key]"><i class="kejar-belum-dikerjakan"></i></div></td>';
        var td2 = '<td><div class="ckeditor-group ckeditor-list"><textarea name="answer[description][]" class="editor-field" id="editor_field_'+ parseInt(number + 1) +'" placeholder="Ketik pilihan jawaban '+ parseInt(number + 1) +'"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
        var td3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
        var newAnswer = '<tr>'+ td1 + td2 + td3 +'</tr>';
        $('.answer-list-table-pg').append(newAnswer);
        refreshCkEditor();
    }
});

btnManagement();

function resetFieldPg(){
    var number = 0;
    $('.answer-list-table-pg tr').each(function(){
        $(this).find('input[type=radio]').val(number);
        $(this).find('textarea').attr({
            'name': 'answer[description]['+ number +']',
            'id': 'editor_field_' + parseInt(number + 1) ,
            'placeholder': 'Ketik pilihan jawaban ' + parseInt(number + 1)
        });
        number++;
    });
    return number;
}

function refreshCkEditor() {
    const ckEditorData = [];
    for (var i = 0; i < ckEditorField.length; i++) {
        ckEditorData[i] = ckEditorField[i].getData();
        ckEditorField[i].destroy();
    }
    ckEditorField = [];
    initalizeCkeditor();
    for (var i = 0; i < ckEditorField.length; i++) {
        ckEditorField[i].setData(ckEditorData[i]);
    }
    btnManagement();
    ckEditorField.filter(function(val){return val});
}

function btnManagement(){
    $(document).on('focus', '.ckeditor-list .ck-content', function(){
        $(this).parents().closest('.ck-editor').next().removeClass('d-none');
    }).on('blur', '.ckeditor-list .ck-content', function(){
        $(this).parents().closest('.ck-editor').next().addClass('d-none');
    });
});

function checkBoxMdManagement(type){
    if (type == 'check') {
        $('.answer-list-table-md input[type=checkbox]').each(function(){
            if ($(this).is(':checked')) {
                $(this).parents().closest('td').next().find('.ck-editor').addClass('active');
            } else {
                $(this).parents().closest('td').next().find('.ck-editor').removeClass('active');
            }
        });
    } else {
        $('.answer-list-table-md input[type=checkbox]').each(function(){
            $(this).prop('checked', false);
        });
    }
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

var ckEditorField = [];


$(document).on('click', '.add-btn', function() {
    if($(this).parent().find('table').data('type') === 'benar_salah') {
        var indexNumber = $(this).parent().find('.benar-salah-input-table').find('tr').length;
        var row = '<tr><td><div class="ckeditor-list"><textarea name="pertanyaan[]" id="" cols="30" rows="1" class="editor-field" placeholder="Ketik pernyataan ' + (indexNumber + 1) + '"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><input type="hidden" name="status_pertanyaan[]"><div class="dropdown custom-dropdown"><button class="btn btn-light dropdown-toggle text-muted" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="dropdown-status">B/S</span><i class="kejar-dropdown"></i></button><div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Benar</a><a class="dropdown-item" href="#">Salah</a></div></div><button class="remove-btn"><i class="kejar-close"></i></button></td></tr>';
        $(this).parent().find('.benar-salah-input-table').append(row);

        $(this).parent().find('.benar-salah-input-table').find('tr').each(function(index, element) {
            $(element).find('.remove-btn').removeClass('d-none');
        });

        initializeEditor(ckEditorField.length, $(this).parent().find('.benar-salah-input-table').find('tr').last().find('textarea')[0]);
    }

    if ($(this).parent().find('table').data('type') === 'mengurutkan') {
        var indexNumber = $(this).parent().find('.mengurutkan-input-table').find('tr').length;
        var row = `<tr><td><div class="num-group"><input type="hidden" name="answer[${ indexNumber }][key]" value="${ indexNumber + 1 }">${ indexNumber + 1 }</div></td><td><div class="ckeditor-group ckeditor-list"><textarea name="answer[${ indexNumber }][description]" class="editor-field" placeholder="Ketik pernyataan/kalimat urutan ${ indexNumber + 1 }" ck-type="mengurutkan"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><div class="btn-action-group"><div class="dropdown dropleft"><button class="sort-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="kejar-drag-vertical"></i></button><div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#"><i class="kejar-top"></i> Geser ke Atas</a><a class="dropdown-item" href="#"><i class="kejar-bottom"></i> Geser ke Bawah</a></div></div><button class="remove-btn" type="button"><i class="kejar-close"></i></button></div></td></tr>`;
        $(this).parent().find('.mengurutkan-input-table').append(row);

        $(this).parent().find('.mengurutkan-input-table').find('tr').each(function(index, element) {
            $(element).find('.remove-btn').removeClass('d-none');
        });

        clearEditorField();

        $(this).parents('.modal-body').find('.editor-field').each((index, element) => {
            initializeEditor(index, element);
        });
    }
});

$(document).on('click', '.custom-dropdown .dropdown-menu a', function() {
    var statusValue = $(this).text();

    $(this).parents('td').find('.dropdown button').removeClass('text-muted');
    $(this).parents('td').find('.dropdown-status').text(statusValue);
    $(this).parents('td').find('input').val(statusValue);
});

$(document).on('click', '.remove-btn', function(e) {
    e.preventDefault();

    var modalBody = $(e.target).parents('.modal-body');

    if ($(this).parents('table').data('type') === 'benar_salah') {
        $(this).parents('tr').remove();

        $(modalBody).find('.benar-salah-input-table').find('tr').each(function(index, element) {
            if (index < 1 && $(modalBody).find('.benar-salah-input-table').find('tr').length == 1) {
                $(element).find('.remove-btn').addClass('d-none');
            }
            $(element).find('textarea').attr('placeholder', 'Ketik pernyataan ' + (index + 1));
        });

        for (let index = 0; index < ckEditorField.length; index++) {
            ckEditorField[index].destroy();
        }

        ckEditorField = [];

        $(modalBody).find('.editor-field').each((index, element) => {
            initializeEditor(index, element);
        });
    }

    if ($(this).parents('table').data('type') === 'mengurutkan') {
        $(this).parents('tr').remove();

        $(modalBody).find('.mengurutkan-input-table').find('tr').each(function(index, element) {
            if (index < 1 && $('.mengurutkan-input-table').find('tr').length == 1) {
                $(element).find('.remove-btn').addClass('d-none');
            }
            $(element).find('.num-group').html(`<input type="hidden" name="answer[key][${index}]" value="${index + 1}">${index+1}`);
            $(element).find('textarea').attr('placeholder', 'Ketik pernyataan/kalimat urutan ' + (index + 1));
        });
        for (let index = 0; index < ckEditorField.length; index++) {
            ckEditorField[index].destroy();
        }

        if ($(modalBody).find('.mengurutkan-input-table tr').length <= 1) {
            $(modalBody).find('.mengurutkan-input-table').find('.remove-btn').addClass('d-none');
        }

        ckEditorField = [];

        $(modalBody).find('.editor-field').each((index, element) => {
            initializeEditor(index, element);
        });
    }
});

$(document).on('show.bs.dropdown', '.custom-dropdown', function () {
    var currentStatus = $(this).find('.dropdown-status').text();
    $(this).find('.dropdown-menu a').each(function(e) {
        if ($(this).text() === currentStatus) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });
});

$('#edit-benar-salah').on('show.bs.modal', (e) => {
    e.stopImmediatePropagation();

    $(e.target).find('form').attr('action', $(e.relatedTarget).data('url'));
    $.ajax({
        type: "GET",
        url: $(e.relatedTarget).data('url'),
        success: function (response) {
            $(e.target).find('textarea[name="keterangan_soal"]').val(response.question);
            $(e.target).find('textarea[name="pembahasan"]').val(response.explanation);
            $(e.target).find('table').html('');
            for (let x = 0; x < Object.keys(response.choices).length; x++) {
                $(e.target).find('table').append(`<tr><td><div class="ckeditor-list"><textarea name="pertanyaan[]" id="" cols="30" rows="1" class="editor-field" placeholder="Ketik pernyataan ' + (x + 1) + '"> ${response.choices[x + 1].question} </textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><input type="hidden" name="status_pertanyaan[]" value="${response.choices[x + 1].answer === true ? 'Benar' : 'Salah'}"><div class="dropdown custom-dropdown"><button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="dropdown-status">${response.choices[x + 1].answer === true ? 'Benar' : 'Salah'}</span><i class="kejar-dropdown"></i></button><div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Benar</a><a class="dropdown-item" href="#">Salah</a></div></div><button class="remove-btn"><i class="kejar-close"></i></button></td></tr>`);
            }

            $(e.target).find('form').find('.editor-field').each((index, element) => {
                initializeEditor(index, element);
            });
        }
    });
});

$('.modal').on('hide.bs.modal', (e) => {
    clearEditorField();
});

$('#create-benar-salah').on('show.bs.modal', (e) => {
    e.stopImmediatePropagation();
    $('#create-soal-cerita-question-modal').modal('hide');

    $(e.target).find('.editor-field').each((index, element) => {
        initializeEditor(index, element);
    });
});

$('#create-benar-salah').on('hide.bs.modal', (e) => {
    $('#create-soal-cerita-question-modal').modal('show');
    clearEditorField();
});

$('#create-mengurutkan').on('show.bs.modal', (e) => {
    e.stopImmediatePropagation();
    $('#create-soal-cerita-question-modal').modal('hide');

    $(e.target).find('.editor-field').each((index, element) => {
        initializeEditor(index, element);
    });
});

$('#create-mengurutkan').on('hide.bs.modal', (e) => {
    $('#create-soal-cerita-question-modal').modal('show');
    clearEditorField();
});

$('#update-mengurutkan').on('show.bs.modal', (e) => {
    e.stopImmediatePropagation();

    $(e.target).find('form').attr('action', $(e.relatedTarget).data('url'));
    $.ajax({
        type: "GET",
        url: $(e.relatedTarget).data('url'),
        success: function (response) {
            $(e.target).find('textarea[name="question[question]"]').val(response.question);
            $(e.target).find('textarea[name="question[description]"]').val(response.explanation);
            $(e.target).find('.mengurutkan-input-table').html('');
            for (let x = 0; x < Object.keys(response.choices).length; x++) {
                $(e.target).find('.mengurutkan-input-table').append(`<tr><td><div class="num-group"><input type="hidden" name="answer[${ x }][key]" value="${ response.choices[x + 1].answer }">${ response.choices[x + 1].answer }</div></td><td><div class="ckeditor-group ckeditor-list"><textarea name="answer[${ x }][description]" class="editor-field" placeholder="Ketik pernyataan/kalimat urutan ${ x + 1 }" ck-type="mengurutkan">${ response.choices[x + 1].question }</textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><div class="btn-action-group"><div class="dropdown dropleft"><button class="sort-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="kejar-drag-vertical"></i></button><div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#"><i class="kejar-top"></i> Geser ke Atas</a><a class="dropdown-item" href="#"><i class="kejar-bottom"></i> Geser ke Bawah</a></div></div><button class="remove-btn" type="button"><i class="kejar-close"></i></button></div></td></tr>`);
            }

            if (Object.keys(response.choices).length <= 1) {
                $(e.target).find('.mengurutkan-input-table').find('.remove-btn').addClass('d-none');
            }

            $(e.target).find('form').find('.editor-field').each((index, element) => {
                initializeEditor(index, element);
            });
        }
    });
});

$('#update-mengurutkan').on('show.bs.modal', (e) => {
    clearEditorField();
});


function clearEditorField() {
    for (let index = 0; index < ckEditorField.length; index++) {
        ckEditorField[index].destroy();
    }

    ckEditorField = [];
    ckEditorFieldLength = 0;
}


$(document).on('click', '.answer-list-table-ur .btn-action-group a:nth-child(1)', function(e){
    e.preventDefault();
    var thisIndex = $(this).parents('tr').index();
    if (thisIndex !== 0) {
        var toIndex = $(this).parents('tr').prev().index();
        var thisData = ckEditorField[thisIndex + 1].getData();
        var toData = ckEditorField[toIndex + 1].getData();
        ckEditorField[thisIndex + 1].setData(toData);
        ckEditorField[toIndex + 1].setData(thisData);
    }
});

$(document).on('click', '.answer-list-table-ur .btn-action-group a:nth-child(2)', function(e){
    e.preventDefault();
    var thisIndex = $(this).parents('tr').index();
    if (thisIndex !== $(this).parents('.answer-list-table-ur').find('tr').length - 1) {
        var toIndex = $(this).parents('tr').next().index();
        var thisData = ckEditorField[thisIndex + 1].getData();
        var toData = ckEditorField[toIndex + 1].getData();
        ckEditorField[thisIndex + 1].setData(toData);
        ckEditorField[toIndex + 1].setData(thisData);
    }
});
