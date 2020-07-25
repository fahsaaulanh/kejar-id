$('#upload-questions').on('show.bs.modal', event => {
    $('#create-question').modal('hide');
});

$('#create-question').on('show.bs.modal', event => {
    $('#upload-questions').modal('hide');
});

$(document).on('click', '.btn-add', function(){
    var index = $('.table-form tbody tr').length;

    $('.table-form').find('tbody').append('<tr><td><input type="text" placeholder="Ketik soal" name="question[' + index + '][question]" class="form-control"></td><td><input type="text" placeholder="Ketik jawaban" name="question['+ index +'][answer]" class="form-control"></td></tr>');
});

$(document).on('change', 'input[type=file]', function(){
    var filename = $(this).val().replace(/C:\\fakepath\\/i, '');

    filename = filename == '' ? 'Pilih file' : filename;
    $(this).parents('.custom-upload').find('input[type=text]').val(filename);
});

$('[data-toggle="popover"]').popover();

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
    url = "{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/') }}/" + id;
    $(modal).find('form').attr('action', url);
    $(modal).find('input[name="question"]').val(question);
    $(modal).find('input[name="answer"]').val(answer);
    $(modal).modal('show');
});