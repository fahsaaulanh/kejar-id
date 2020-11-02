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
    } else if (type == 'menulis-efektif'){
        var textAreaAnswer = $(this).prev().find('tr');
        var textAreaNum = 0;
        textAreaAnswer.each(function(){
            $(this).find('input').attr('name', 'question[answer]['+ textAreaNum +']');
            $(this).find('.inputgrow-field').attr('placeholder', 'Ketik alternatif jawaban '+ (textAreaNum + 1));
            textAreaNum++;
        });
        var td1 = '<td><input type="hidden" name="question[answer]['+ textAreaNum +']"><div contenteditable="true" class="inputgrow-field" placeholder="Ketik alternatif jawaban '+ parseInt(textAreaNum + 1) +'"></div></td>';
        var td2 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
        var data = '<tr>'+ td1 + td2 +'</tr>';
        $(this).prev().append(data);
    } else {
        $('.table-form').find('tbody').append('<tr><td><input type="text" placeholder="Ketik soal" name="question[' + index + '][question]" class="form-control"></td><td><input type="text" placeholder="Ketik jawaban" name="question['+ index +'][answer]" class="form-control"></td></tr>');
    }
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
                    answersData += '<tr><td colspan="2"><input type="hidden" name="question[answer][0]" value="'+ response.answer +'"><div contenteditable="true" class="inputgrow-field" placeholder="Ketik alternatif jawaban 1">'+ response.answer +'</div></td></tr>';
                }
                modal.find('table').html(answersData);
                modal.modal('show');
            }
        }
    });
});

$(document).on('click', '.remove-btn', function(){
    var type = $(this).parents('table').attr('data-type');
    if (type == 'menulis-efektif') {
        var thisParent1 = $(this).parents('tr');
        var thisParent2 = thisParent1.parent();
        thisParent1.remove();
        var textAreaNum = 0;
        thisParent2.find('tr').each(function(){
            $(this).find('input').attr('name', 'question[answer]['+ textAreaNum +']');
            $(this).find('.inputgrow-field').attr('placeholder', 'Ketik alternatif jawaban '+ (textAreaNum + 1));
            textAreaNum++;
        });
    }
});

$(document).on('input', '.inputgrow-field', function(){
    $(this).prev().val($(this).html());
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

$(document).on('click', '.answer-list-table-ur .btn-action-group a:nth-child(1)', function(e){
    e.preventDefault();
    var thisIndex = $(this).parents('tr').index();
    var toIndex = $(this).parents('tr').prev().index();
    var thisData = ckEditorDataUr[thisIndex].getData();
    var toData = ckEditorDataUr[toIndex].getData();
    ckEditorDataUr[thisIndex].setData(toData);
    ckEditorDataUr[toIndex].setData(thisData);
});

$(document).on('click', '.answer-list-table-ur .btn-action-group a:nth-child(2)', function(e){
    e.preventDefault();
    var thisIndex = $(this).parents('tr').index();
    var toIndex = $(this).parents('tr').next().index();
    var thisData = ckEditorDataUr[thisIndex].getData();
    var toData = ckEditorDataUr[toIndex].getData();
    ckEditorDataUr[thisIndex].setData(toData);
    ckEditorDataUr[toIndex].setData(thisData);
});

$(document).on('click', '.remove-btn', function(){
    var type = $(this).parents('table').attr('data-type');
    $(this).parents('tr').remove();
    if (type == 'mengurutkan') {
        for (var i = 0; i < ckEditorDataUr.length; i++) {
            ckEditorDataUr[i].destroy();
        }
        ckEditorDataUr = [];
        initalizeCkEditorUr();
        var number = 0;
        $('.answer-list-table-ur tr').each(function(){
            $(this).children().eq(0).html('<div class="num-group"><input type="hidden" name="answer[key]['+ number +']" value="'+ number +'">' + parseInt(number + 1) + '</div>');
            $(this).find('textarea').attr({
                'name': 'answer[description]['+ number +']',
                'placeholder': 'Ketik pernyataan/kalimat urutan ' + parseInt(number + 1)
            });
            number++;
        });
        var totalField = $('.answer-list-table-ur tr').length;
        if (totalField == 2) {
            $('.answer-list-table-ur tr').each(function(){
                var removeBtn = $(this).find('.remove-btn');
                removeBtn.parents('td').addClass('cols-2');
                removeBtn.remove();
            });
        }
        sortBtnManagement();
    }
});

$(document).on('click', '.add-btn', function(){
    var type = $(this).attr('data-type');
    if (type == 'mengurutkan') {
        var totalField = $('.answer-list-table-ur tr').length;
        if (totalField == 2) {
            $('.answer-list-table-ur tr').each(function(){
                var actionBtn = $(this).children().find('.btn-action-group');
                var removeBtn = '<button class="remove-btn" type="button"><i class="kejar-close"></i></button>';
                actionBtn.parent().removeClass('cols-2');
                actionBtn.append(removeBtn);
            });
        }
        var td1 = '<td><div class="num-group"><input type="hidden" name="answer[key][]" value="'+ totalField +'">'+ parseInt(totalField + 1) +'</div></td>';
        var td2 = '<td><div class="ckeditor-group ckeditor-list"><textarea name="answer[description]['+ totalField +']" class="editor-field" placeholder="Ketik pernyataan/kalimat urutan '+ parseInt(totalField + 1) +'" ck-type="mengurutkan" required></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
        var td3 = '<td><div class="btn-action-group"><div class="dropdown dropleft"><button class="sort-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="kejar-drag-vertical"></i></button><div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#"><i class="kejar-top"></i> Geser ke Atas</a><a class="dropdown-item" href="#"><i class="kejar-bottom"></i> Geser ke Bawah</a></div></div><button class="remove-btn" type="button"><i class="kejar-close"></i></button></div></td>';
        var newAnswer = '<tr>'+ td1 + td2 + td3 +'</tr>';
        $('.answer-list-table-ur').append(newAnswer);
        initalizeEditor(totalField, $(this).prev().children().find('.editor-field').last()[0]);
        sortBtnManagement();
    }
});

$(document).on('focus', '.ckeditor-list .ck-content', function(){
    $(this).parents().closest('.ck-editor').next().removeClass('d-none');
}).on('blur', '.ckeditor-list .ck-content', function(){
    $(this).parents().closest('.ck-editor').next().addClass('d-none');
});