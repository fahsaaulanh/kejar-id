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

    $('.table-form').find('tbody').append('<tr><td><input type="text" placeholder="Ketik soal" name="question[' + index + '][question]" class="form-control"></td><td><input type="text" placeholder="Ketik jawaban" name="question['+ index +'][answer]" class="form-control"></td></tr>');
});

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

$(document).on('click', '.bold-btn', function(){
    $('.cke_button__bold').click();
});

$(document).on('click', '.italic-btn', function(){
    $('.cke_button__italic').click();
});

$(document).on('click', '.underline-btn', function(){
    $('.cke_button__underline').click();
});

$(document).on('click', '.number-list-btn', function(){
    $('.cke_button__numberedlist').click();
});

$(document).on('click', '.bullet-list-btn', function(){
    $('.cke_button__bulletedlist').click();
});

$(document).on('click', '.btn-delete-answer', function(){
    $(this).parent().remove();
});