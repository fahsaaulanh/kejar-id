const { ajax } = require("jquery");

// Initalizing TextEditor
$(document).on('click', '.ckeditor-btn-1 .bold-btn', function(e){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(0)').click();
    checkActive(e);
});

$(document).on('click', '.ckeditor-btn-1 .italic-btn', function(e){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(1)').click();
    checkActive(e);
});

$(document).on('click', '.ckeditor-btn-1 .underline-btn', function(e){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(2)').click();
    checkActive(e);
});

$(document).on('click', '.ckeditor-btn-1 .bullet-list-btn', function(e){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(3)').click();
    checkActive(e);
});

$(document).on('click', '.ckeditor-btn-1 .number-list-btn', function(e){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(4)').click();
    checkActive(e);
});

$(document).on('click', '.ckeditor-btn-1 .photo-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items span button').click();
});

$(document).on('click', '.ck-content p, .ck-content ul li, .ck-content ol li', function(e){
    checkActive(e);
});

$(document).keydown(function(e){
    checkActive(e);
});

function checkActive(e){
    if ($(e.target).parents('.ck-reset').find('.ck-toolbar__items button:eq(0)').hasClass('ck-on')) {
        $(e.target).parents('.ck-reset').next().find('.bold-btn').addClass('active');
    } else {
        $(e.target).parents('.ck-reset').next().find('.bold-btn').removeClass('active');
    }

    if ($(e.target).parents('.ck-reset').find('.ck-toolbar__items button:eq(1)').hasClass('ck-on')) {
        $(e.target).parents('.ck-reset').next().find('.italic-btn').addClass('active');
    } else {
        $(e.target).parents('.ck-reset').next().find('.italic-btn').removeClass('active');
    }

    if ($(e.target).parents('.ck-reset').find('.ck-toolbar__items button:eq(2)').hasClass('ck-on')) {
        $(e.target).parents('.ck-reset').next().find('.underline-btn').addClass('active');
    } else {
        $(e.target).parents('.ck-reset').next().find('.underline-btn').removeClass('active');
    }

    if ($(e.target).parents('.ck-reset').find('.ck-toolbar__items button:eq(3)').hasClass('ck-on')) {
        $(e.target).parents('.ck-reset').next().find('.bullet-list-btn').addClass('active');
    } else {
        $(e.target).parents('.ck-reset').next().find('.bullet-list-btn').removeClass('active');
    }

    if ($(e.target).parents('.ck-reset').find('.ck-toolbar__items button:eq(4)').hasClass('ck-on')) {
        $(e.target).parents('.ck-reset').next().find('.number-list-btn').addClass('active');
    } else {
        $(e.target).parents('.ck-reset').next().find('.number-list-btn').removeClass('active');
    }
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

var editorArray = [];

function generateEditor(index, element) {

    showLoader();

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
                    name: 'imageResize:25',
                    label: '25%',
                    value: '25'
                },
                {
                    name: 'imageResize:30',
                    label: '30%',
                    value: '30'
                },
                {
                    name: 'imageResize:35',
                    label: '35%',
                    value: '35'
                },
                {
                    name: 'imageResize:40',
                    label: '40%',
                    value: '40'
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

    setTimeout(() => {
        hideLoader();
    }, 1000);

}

function clearEditorField() {
    for (var i = 0; i < editorArray.length; i++) {
        editorArray[i].destroy();
    }
    editorArray = [];
}
// End Initializing TextEditor

// Loader
function showLoader() {
    $('body').css('pointer-events', 'none');
    $('body').append(`<div class="loader" style="position: fixed; z-index: 10000; width: auto; height: 30px; background: white; bottom: 10px; left: 10px; display: flex; align-items: center; justify-content: center;">
        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>`);
}

function hideLoader() {
    $('body').css('pointer-events', 'auto');
    $('.loader').remove();
}
// End Loader

// Copy ID
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
// End Copy ID

// Modals
$('.edit-title').dblclick(function(e) {
    updateModal('#rename-title', $(e.currentTarget).html(), 'input');
});

$('.edit-description').dblclick(function(e) {
    updateModal('#update-description', $(e.currentTarget).html());
});

$('.edit-wacana').dblclick(function(e) {
    updateModal('#update-wacana', $(e.currentTarget).html() === 'Buat Wacana' ? '' : $(e.currentTarget).html());
});

function updateModal(id, html, type = 'textarea') {
    $(id).find(type).val(html);
    $(id).modal('show');
}

$(".modal").on("show.bs.modal", function(e){
    $(e.currentTarget).find('.editor-field').each((index, element) => {
        generateEditor(index, element);
    });
});

$(".modal").on("hidden.bs.modal", function(){
    clearEditorField();
});
// End Modals

// Add BTN
$(document).on('click', '.add-btn', function() {
    var type = $(this).data('type');
    var modal = $(this).parents('.modal');

    // Pilihan Ganda
    if (type === 'pilihan-ganda') {
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
            var td2 = '<td><div class="ckeditor-group ckeditor-list"><textarea name="choices['+ totalField +']" class="editor-field" placeholder="Ketik pilihan jawaban '+ parseInt(totalField + 1) +'" ck-type="pilihan-ganda" required></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
            var td3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
            var newAnswer = '<tr>'+ td1 + td2 + td3 +'</tr>';
            thisModal.find('.answer-list-table-pg').append(newAnswer);
            generateEditor(editorArray.length, $(this).prev().children().find('.editor-field').last()[0]);
        }
        radioPgManagement();
    }
    // End Pilihan Ganda

    // Menceklis Daftar
    if (type === 'menceklis-daftar'){
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
        var td2 = '<td><div class="ckeditor-group ckeditor-list"><textarea name="choices['+ totalField +']" class="editor-field editor-field" placeholder="Ketik pilihan jawaban '+ parseInt(totalField + 1) +'" ck-type="menceklis-daftar" required></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
        var td3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
        var newAnswer = '<tr>'+ td1 + td2 + td3 +'</tr>';
        modal.find('.answer-list-table-md').append(newAnswer);
        generateEditor(editorArray.length, $(this).prev().children().find('.editor-field').last()[0]);
        checkBoxMdManagement('check');
    }
    // End Menceklis Daftar

    // Benar Salah
    if(type === 'benar_salah') {
        var indexNumber = $(this).parent().find('.benar-salah-input-table').find('tr').length;
        var row = '<tr><td><div class="ckeditor-list"><textarea name="pertanyaan[]" id="" cols="30" rows="1" class="editor-field" placeholder="Ketik pernyataan ' + (indexNumber + 1) + '"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><input type="hidden" name="status_pertanyaan[]"><div class="dropdown custom-dropdown"><button class="btn btn-light dropdown-toggle text-muted" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="dropdown-status">B/S</span><i class="kejar-dropdown"></i></button><div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Benar</a><a class="dropdown-item" href="#">Salah</a></div></div><button class="remove-btn"><i class="kejar-close"></i></button></td></tr>';
        $(this).parent().find('.benar-salah-input-table').append(row);

        $(this).parent().find('.benar-salah-input-table').find('tr').each(function(index, element) {
            $(element).find('.remove-btn').removeClass('d-none');
        });

        generateEditor(editorArray.length, $(this).parent().find('.benar-salah-input-table').find('tr').last().find('textarea')[0]);
    }
    // End Benar Salah

    // Ya Tidak
    if (type === 'ya_tidak') {
        var indexNumber = $(this).parent().find('.ya-tidak-input-table').find('tr').length;
        var row = `<tr><td><div class="ckeditor-list"><textarea name="question[]" class="editor-field" placeholder="Ketik pernyataan ${indexNumber +1 }"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><input type="hidden" name="answer[]"><div class="dropdown custom-dropdown"><button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="dropdown-status">Y/T</span><i class="kejar-dropdown"></i></button><div class="dropdown-menu w-100" aria-labelledby=""><a class="dropdown-item" href="#">Ya</a><a class="dropdown-item" href="#">Tidak</a></div></div><button class="remove-btn"><i class="kejar-close"></i></button></td></tr>`;
        $(this).parent().find('.ya-tidak-input-table').append(row);

        $(this).parent().find('.ya-tidak-input-table').find('tr').each(function(index, element) {
            $(element).find('.remove-btn').removeClass('d-none');
        });

        generateEditor(editorArray.length, $(this).parent().find('.ya-tidak-input-table').find('tr').last().find('textarea')[0]);
    }
    // End Ya Tidak

    // Mengurutkan
    if (type === 'mengurutkan') {
        var indexNumber = $(this).parent().find('.mengurutkan-input-table').find('tr').length;
        var row = `<tr><td><div class="num-group"><input type="hidden" name="answer[${ indexNumber }][key]" value="${ indexNumber + 1 }">${ indexNumber + 1 }</div></td><td><div class="ckeditor-group ckeditor-list"><textarea name="answer[${ indexNumber }][description]" class="editor-field" placeholder="Ketik pernyataan/kalimat urutan ${ indexNumber + 1 }" ck-type="mengurutkan"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><div class="btn-action-group"><div class="dropdown dropleft"><button class="sort-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="kejar-drag-vertical"></i></button><div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#"><i class="kejar-top"></i> Geser ke Atas</a><a class="dropdown-item" href="#"><i class="kejar-bottom"></i> Geser ke Bawah</a></div></div><button class="remove-btn" type="button"><i class="kejar-close"></i></button></div></td></tr>`;
        $(this).parent().find('.mengurutkan-input-table').append(row);

        $(this).parent().find('.mengurutkan-input-table').find('tr').each(function(index, element) {
            $(element).find('.remove-btn').removeClass('d-none');
        });

        clearEditorField();

        $(this).parents('.modal-body').find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    }
    // End Mengurutkan

    // Memasangkan
    if (type === 'memasangkan') {
        var modal = $(this).parents('.modal');
        var totalField = modal.find('.answer-list-table-ps tr').length;
        if (totalField == 2) {
            modal.find('.answer-list-table-ps tr').each(function(){
                var secondField = $(this).children().eq(1);
                var removeBtn = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
                secondField.attr('colspan', 1);
                secondField.removeClass('colspan-2');
                $(this).append(removeBtn);
            });
        }
        var td1 = '<td><div class="num-group">'+ parseInt(totalField + 1) +'</div></td>';
        var td2 = '<td><div class="ckeditor-group ckeditor-list mb-3"><textarea name="answer[statement]['+ totalField +']" class="editor-field" placeholder="Ketik pernyataan '+ parseInt(totalField + 1) +'" ck-type="memasangkan"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div><div class="ckeditor-group ckeditor-list"><textarea name="answer[setstatement]['+ totalField +']" class="editor-field" placeholder="Ketik pasangan pernyataan '+ parseInt(totalField + 1) +'" ck-type="memasangkan"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
        var td3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
        var newAnswer = '<tr>'+ td1 + td2 + td3 +'</tr>';
        modal.find('.answer-list-table-ps').append(newAnswer);
        clearEditorField();
        modal.find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    }
    // End Memasangkan

    // Merinci
    if (type === 'merinci') {
        var modal = $(this).parents('.modal');
        var totalField = modal.find('.answer-list-table-rc tr').length;
        if (totalField == 2) {
            modal.find('.answer-list-table-rc tr').each((index, element) => {
                $(element).find('.remove-btn').removeClass('d-none');
            });
        }

        var row = `<tr><td><textarea name="answer[]" hidden></textarea><div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik jawaban ${parseInt(totalField+1)}"></div></td><td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td></tr>`;

        modal.find('.answer-list-table-rc').append(row);
    }
    // End Merinci

    // Isian Bahasa
    if (type == 'isian-bahasa') {
        var modal = $(this).parents('.modal');
        var totalField = modal.find('.answer-list-table-ib tr').length;
        var td1 = '<td><input type="hidden" name="answer['+ totalField +']"><div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik alternatif jawaban '+ parseInt(totalField + 1) +'"></div></td>';
        var td2 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
        var newAnswer = '<tr>'+ td1 + td2 +'</tr>';
        modal.find('.answer-list-table-ib').append(newAnswer);
    }
    // End Isian Bahasa

    // Isian Matematika
    if (type === 'isian_matematika') {
        var indexNumber = $(this).parent().find('.isian-matematika-input-table').find('tr').length;
        var row = `<tr><td><div class="ckeditor-list"><textarea name="first[]" class="editor-field" placeholder="Ketik awalan"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><textarea name="answer[]" class="_isian_matematika_input_answer" placeholder="Ketik jawaban"></textarea></td><td><div class="ckeditor-list"><textarea name="last[]" class="editor-field" placeholder="Ketik akhiran"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td><td><button class="remove-btn"><i class="kejar-close"></i></button></td></tr>`;
        $(this).parent().find('.isian-matematika-input-table').append(row);

        $(this).parent().find('.isian-matematika-input-table').find('tr').each(function(index, element) {
            $(element).find('.remove-btn').removeClass('d-none');
        });

        for (let index = 0; index < 3; index++) {
            generateEditor(editorArray.length + index, $(this).parent().find('.isian-matematika-input-table').find('tr').last().find('.editor-field')[index]);
        }
    }
    // End Isian Matematika

    // Melengkapi Tabel
    if (type === 'melengkapi_tabel') {
        var columnAmount = $('#create-melengkapi-tabel-column').find('input[name="column_amount"]').val();

        var defaultInput = $(this).parent().find('.melengkapi-tabel-input-table').find('tr').last().data('row') + 1;

        var appendHTML = `<tr data-row="${defaultInput}">`;

        for (let columnBody = 0; columnBody < columnAmount; columnBody++) {
            appendHTML += `<td><input type="hidden" name="column[status][${defaultInput}][]" value="" /><div class="dropdown custom-dropdown"><button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="dropdown-status">Soal/Jawaban</span><i class="kejar-dropdown"></i></button><div class="dropdown-menu w-100"><a class="dropdown-item" href="#">Soal</a><a class="dropdown-item" href="#">Jawaban</a></div></div><div class="ckeditor-list"><textarea placeholder="Ketik data" name="column[content][${defaultInput}][]" class="form-control"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>`;
        }

        appendHTML += '<td><button class="remove-btn"><i class="kejar-close"></i></button></td></tr>';

        $(this).parent().find('.melengkapi-tabel-input-table').append(appendHTML);

        $(this).parent().find('.melengkapi-tabel-input-table').find('tr').each(function(index, element) {
            $(element).find('.remove-btn').removeClass('d-none');
        });
    }
    // End Melengkapi Tabel

    // Teks Rumpang PG
    if (type == 'next-rumpang-pg') {
        var modal = $(this).parents('.modal');
        var prevType = $(this).parent().prev();
        var choicesLength = parseInt(modal.find('.form-group.bagian-rumpang').length + modal.find('.form-group.lanjutan-teks').length);
        if (prevType.hasClass('bagian-rumpang')) {
            var td1 = '<td><div class="ckeditor-group ckeditor-list"><textarea class="textarea-field editor-field" name="choices[' + choicesLength + ']" placeholder="Ketik teks" ck-type="teks-rumpang-pg"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
            var td2 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
            var textLanjutan = '<div class="form-group ck-height-9 ckeditor-list lanjutan-teks"><label>Lanjutan Teks Soal</label><table class="text-list-table-rmpg" data-type="tabel-lanjut-text"><colgroup><col class="first-td"/><col class="second-td"/></colgroup><tr>' + td1 + td2 + '</tr></table></div>';
            $(textLanjutan).insertBefore($(this).parent());
            clearEditorField();
            modal.find('.editor-field').each((index, element) => {
                generateEditor(index, element);
            });
            addTypeRmpg($(this));
        } else {
            var row = '';
            for (var i = 0; i < 4; i++) {
                var td1 = '<td><div class="radio-group"><input type="radio" name="choices[' + choicesLength + '][answer]" value="' + i + '"><i class="kejar-belum-dikerjakan"></i></div></td>';
                var td2 = '<td><textarea name="choices[' + choicesLength + '][description][]" hidden></textarea><div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik pilihan jawaban ' + parseInt(i + 1) + '"></div></td>';
                var td3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
                row += '<tr>' + td1 + td2 + td3 + '</tr>';
            }
            var bagianRumpang = '<div class="form-group bagian-rumpang"><div class="d-flex justify-content-between align-items-start"><div><label>Jawaban</label><p>Semua alternatif jawaban dianggap benar.</p></div><button class="remove-btn" type="button" data-type="bagian-rumpang"><i class="kejar-close"></i></button></div><table class="answer-list-table-rmpg" data-type="tabel-rumpang-pg">' + row + '</table><button class="btn btn-add border-0 pl-0 add-btn" type="button" data-type="jawaban-rumpang-pg"><i class="kejar-add"></i> Tambah Pilihan Jawaban</button></div>';
            $(bagianRumpang).insertBefore($(this).parent());
            addTypeRmpg($(this));
        }
        setTimeout(function () { radioRmpgManagement(); }, 50);
    } else if (type == 'jawaban-rumpang-pg') {
        var totalField = $(this).prev().find('tr').length;
        var index = $(this).prev().index('.answer-list-table-rmpg');
        if (totalField == 2) {
            $(this).prev().find('tr').each(function () {
                var removeBtn = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
                $(this).append(removeBtn);
            });
        }
        var td1 = '<td><div class="radio-group"><input type="radio" name="choices[' + index + '][answer]" value="' + totalField + '"><i class="kejar-belum-dikerjakan"></i></div></td>';
        var td2 = '<td><textarea name="choices[' + index + '][description][]" hidden></textarea><div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik pilihan jawaban ' + parseInt(totalField + 1) + '"></div></td>';
        var td3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
        var newAnswer = '<tr>' + td1 + td2 + td3 + '</tr>';
        $(this).prev().append(newAnswer);
        setTimeout(function () { radioRmpgManagement(); }, 50);
    }
    // End Teks Rumpang PG
    
});
// End Add BTN


// Remove BTN
$(document).on('click', '.remove-btn', function(e) {
    e.preventDefault();

    var type = $(this).parents('table').data('type');
    var modalBody = $(this).parents('.modal-body');

    // Pilihan Ganda
    if (type === 'pilihan-ganda') {
        var thisModal = $(this).parents('.modal');
        $(this).parents('tr').remove();
        clearEditorField();
        thisModal.find('.editor-field').each((index, element) => {
            generateEditor(index, element);
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
    // End Pilihan Ganda

    // Menceklis Daftar
    if (type === 'menceklis-daftar') {
        var modal = $(this).parents('.modal');
        $(this).parents('tr').remove();
        clearEditorField();
        modal.find('.editor-field').each((index, element) => {
            generateEditor(index, element);
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
    // End Menceklis Daftar

    // Benar Salah
    if (type === 'benar_salah') {
        $(this).parents('tr').remove();

        $(modalBody).find('.benar-salah-input-table').find('tr').each(function(index, element) {
            if (index < 1 && $(modalBody).find('.benar-salah-input-table').find('tr').length == 1) {
                $(element).find('.remove-btn').addClass('d-none');
            }
            $(element).find('textarea').attr('placeholder', 'Ketik pernyataan ' + (index + 1));
        });

        for (let index = 0; index < editorArray.length; index++) {
            editorArray[index].destroy();
        }

        editorArray = [];

        $(modalBody).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    }
    // End Benar Salah

    // Ya Tidak
    if (type === 'ya_tidak') {
        $(this).parents('tr').remove();

        $(modalBody).find('.ya-tidak-input-table').find('tr').each(function(index, element) {
            if (index < 1 && $(modalBody).find('.ya-tidak-input-table').find('tr').length == 1) {
                $(element).find('.remove-btn').addClass('d-none');
            }
            $(element).find('textarea').attr('placeholder', 'Ketik pernyataan ' + (index + 1));
        });

        for (let index = 0; index < editorArray.length; index++) {
            editorArray[index].destroy();
        }

        editorArray = [];

        setTimeout(() => {
            $(modalBody).find('.editor-field').each((index, element) => {
                generateEditor(index, element);
            });
        }, 1);

    }
    // End Ya Tidak

    // Mengurutkan
    if (type === 'mengurutkan') {
        $(this).parents('tr').remove();

        $(modalBody).find('.mengurutkan-input-table').find('tr').each(function(index, element) {
            if (index < 1 && $('.mengurutkan-input-table').find('tr').length == 1) {
                $(element).find('.remove-btn').addClass('d-none');
            }
            $(element).find('.num-group').html(`<input type="hidden" name="answer[${index}][key]" value="${index + 1}">${index+1}`);
            $(element).find('textarea').attr('placeholder', 'Ketik pernyataan/kalimat urutan ' + (index + 1)).attr('name', `answer[${ index }][description]`);
        });
        for (let index = 0; index < editorArray.length; index++) {
            editorArray[index].destroy();
        }

        if ($(modalBody).find('.mengurutkan-input-table tr').length <= 1) {
            $(modalBody).find('.mengurutkan-input-table').find('.remove-btn').addClass('d-none');
        }

        editorArray = [];

        $(modalBody).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    }
    // End Mengurutkan

    // Memasangkan
    if (type === 'memasangkan') {
        var modal = $(this).parents('.modal');
        $(this).parents('tr').remove();
        clearEditorField();
        modal.find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
        var number = 0;
        modal.find('.answer-list-table-ps tr').each(function(){
            $(this).children().eq(0).html('<div class="num-group">'+ parseInt(number + 1) +'</div>');
            $(this).find('textarea').eq(0).attr({
                'name': 'answer[statement]['+ number +']',
                'placeholder': 'Ketik pernyataan ' + parseInt(number + 1)
            });
            $(this).find('textarea').eq(1).attr({
                'name': 'answer[setstatement]['+ number +']',
                'placeholder': 'Ketik pasangan pernyataan ' + parseInt(number + 1)
            });
            number++;
        });
        var totalField = modal.find('.answer-list-table-ps tr').length;
        if (totalField == 2) {
            modal.find('.answer-list-table-ps tr').each(function(){
                var secondField = $(this).children().eq(1);
                secondField.attr('colspan', 2);
                secondField.addClass('colspan-2');
                $(this).children().eq(2).remove();
            });
        }
    }
    // End Memasangkan

    // Merinci
    if (type === 'merinci') {
        var number = 0;
        var modal = $(this).parents('.modal');
        $(this).parents('tr').remove();
        modal.find('.answer-list-table-rc tr').each(function(){
            $(this).find('.answer-field').attr('placeholder', 'Ketik jawaban ' + parseInt(number + 1));
            number++;
        });
        var totalField = modal.find('.answer-list-table-rc tr').length;
        if (totalField == 2) {
            modal.find('.answer-list-table-rc tr').each((index, element) => {
                $(element).find('.remove-btn').addClass('d-none');
            });
        }
    }
    // End Merinci

    // Isian Bahasa
    if (type == 'isian-bahasa') {
        var modal = $(this).parents('.modal');
        $(this).parents('tr').remove();
        $(this).find('.answer-list-table-ib tr').each((element, index) => {
            $(element).find('.answer-field').attr('placeholder', `Ketik alternatif jawaban ${parseInt(index + 1)}`);
        });
    }
    // End Isian Bahasa

    // Isian Matematika
    if (type === 'isian_matematika') {
        $(this).parents('tr').remove();

        $(modalBody).find('.isian-matematika-input-table').find('tr').each(function(index, element) {
            if (index < 1 && $(modalBody).find('.isian-matematika-input-table').find('tr').length == 1) {
                $(element).find('.remove-btn').addClass('d-none');
            }
        });

        for (let index = 0; index < editorArray.length; index++) {
            editorArray[index].destroy();
        }

        editorArray = [];

        $(modalBody).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    }
    // End Isian Matematika

    // Melengkapi Tabel
    if (type === 'melengkapi_tabel') {
        $(this).parents('tr').remove();

        $(modalBody).find('.melengkapi-table-input-table').find('tr').each(function(index, element) {
            if (index < 1 && $(modalBody).find('.melengkapi-table-input-table').find('tr').length == 1) {
                $(element).find('.remove-btn').addClass('d-none');
            }
        });
    }
    // End Melengkapi Tabel

    // Teks Rumpang PG
    if ($(e.currentTarget).attr('data-type') == 'bagian-rumpang') {
        var modal = $(this).parents('.modal');
        $(this).parents('.bagian-rumpang').remove();
        clearEditorField();
        modal.find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
        addTypeRmpg($('.add-btn[data-type=next-rumpang-pg]'));
        setTimeout(function () { radioRmpgManagement(); }, 50);
    }
    
    if (type == 'tabel-lanjut-text') {
            var modal = $(this).parents('.modal');
            $(this).parents('.lanjutan-teks').remove();
            clearEditorField();
            modal.find('.editor-field').each((index, element) => {
                generateEditor(index, element);
            });
            addTypeRmpg($('.add-btn[data-type=next-rumpang-pg]'));
    }
    
    if (type == 'tabel-rumpang-pg') {
        var trList = $(this).parents('.answer-list-table-rmpg');
        $(this).parents('tr').remove();
        var number = 0;
        trList.find('tr').each(function () {
            $(this).find('input[type=radio]').val(number);
            $(this).find('div[contenteditable=true]').attr('placeholder', 'Ketik pilihan jawaban ' + parseInt(number + 1));
            number++;
        });
        var totalField = trList.find('tr').length;
        if (totalField == 2) {
            trList.find('tr').each(function () {
                $(this).children().eq(2).remove();
            });
        }
        setTimeout(function () { radioRmpgManagement(); }, 50);
    }
    // End Teks Rumpang PG
});
// End Remove BTN

// Dropdown
$(document).on('click', '.custom-dropdown .dropdown-menu a', function() {
    var statusValue = $(this).text();

    var modalBody = $(this).parents('.modal-body');

    if ($(modalBody).find('table').data('type') === 'melengkapi_tabel') {
        if (statusValue === 'Jawaban') {
            $(this).parents('td').find('textarea').addClass('input-valid').removeClass('editor-field');
            if ($(this).parents('td').find('textarea').data('index') !== undefined) {
                editorArray[$(this).parents('td').find('textarea').data('index')].destroy();
                $(this).parents('td').find('textarea').removeAttr('data-index');
            }
        } else if (statusValue === 'Soal') {
            if ($(this).parents('td').find('textarea').attr('data-index') === undefined) {
                $(this).parents('td').find('textarea').removeClass('input-valid').addClass('editor-field').attr('data-index', editorArray.length);
                generateEditor(editorArray.length, $(this).parents('td').find('textarea')[0]);
            }
        }
    }

    $(this).parents('td').find('.dropdown button').removeClass('text-muted');
    $(this).parents('td').find('.dropdown-status').text(statusValue);
    $(this).parents('td').find('input').val(statusValue);
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
// End Dropdown

// RADIO MANAGEMENT
$(document).on('input', '.answer-list-table-pg input[type=radio]', function() {
    radioPgManagement();
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
// END RADIO MANAGEMENT

// CUSTOMED
function radioRmpgManagement(){
    $('.answer-list-table-rmpg input[type=radio]').each(function(){
        if ($(this).is(':checked')) {
            $(this).parents('td').next().find('div[contenteditable=true]').addClass('active');
        } else {
            $(this).parents('td').next().find('div[contenteditable=true]').removeClass('active');
        }
    });
}

function addTypeRmpg(element) {
    var prevType = element.parent().prev();
    if (prevType.hasClass('bagian-rumpang')) {
        element.html('<i class="kejar-add"></i> Tambah Lanjutan Teks');
    } else {
        element.html('<i class="kejar-add"></i> Tambah Bagian Rumpang');
    }
}
// END CUSTOMED

// CHECKBOX MANAGEMENT
$(document).on('input', '.answer-list-table-md input[type=checkbox]', function() {
    checkBoxMdManagement('check');
});

$('.modal').on('hide.bs.modal', function() {
    checkBoxMdManagement('unchecked');
});

function checkBoxMdManagement(type){
    if (type === 'check') {
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
// END CHECKBOX MANAGEMENT

// MENGURUTKAN
$(document).on('click', '.answer-list-table-ur .btn-action-group a:nth-child(1)', function(e){
    e.preventDefault();
    var thisIndex = $(this).parents('tr').index();
    if (thisIndex !== 0) {
        var toIndex = $(this).parents('tr').prev().index();
        var thisData = editorArray[thisIndex + 1].getData();
        var toData = editorArray[toIndex + 1].getData();
        editorArray[thisIndex + 1].setData(toData);
        editorArray[toIndex + 1].setData(thisData);
    }
});

$(document).on('click', '.answer-list-table-ur .btn-action-group a:nth-child(2)', function(e){
    e.preventDefault();
    var thisIndex = $(this).parents('tr').index();
    if (thisIndex !== $(this).parents('.answer-list-table-ur').find('tr').length - 1) {
        var toIndex = $(this).parents('tr').next().index();
        var thisData = editorArray[thisIndex + 1].getData();
        var toData = editorArray[toIndex + 1].getData();
        editorArray[thisIndex + 1].setData(toData);
        editorArray[toIndex + 1].setData(thisData);
    }
});
// END MENGURUTKAN

// ANSWER FIELD
$(document).on('input', '.answer-field', (e) => {
    $(e.currentTarget).prev('textarea').html($(e.currentTarget).html());
    $(e.currentTarget).prev('input').val($(e.currentTarget).text());
});
// ANSWER FIELD

// MELENGKAPI TABEL
$('#create-melengkapi-tabel-column').on('show.bs.modal', (e) => {
    e.stopImmediatePropagation();
    $('#question-type').modal('hide');
});

$('#create-melengkapi-tabel').on('shown.bs.modal', (e) => {
    e.stopImmediatePropagation();
    $('#create-melengkapi-tabel-column').modal('hide');
    $('body').css('overflow-y', 'hidden');

    var columnAmount = $('#create-melengkapi-tabel-column').find('input[name="column_amount"]').val();

    var columnHTML = "<tr>";

    for (let columnHeader = 0; columnHeader < columnAmount; columnHeader++) {
        columnHTML += `<td><input type="text" placeholder="Ketik judul kolom" name="header[]" class="form-control"></td>`;
    }

    columnHTML += "<td></td></tr>";

    $('.melengkapi-tabel-input-table').html(columnHTML);

    for (let defaultInput = 0; defaultInput < 3; defaultInput++) {
        var appendHTML = `<tr data-row="${defaultInput}">`;

        for (let columnBody = 0; columnBody < columnAmount; columnBody++) {
            appendHTML += `<td><input type="hidden" name="column[status][${defaultInput}][]" value="" /><div class="dropdown custom-dropdown"><button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="dropdown-status">Soal/Jawaban</span><i class="kejar-dropdown"></i></button><div class="dropdown-menu w-100"><a class="dropdown-item" href="#">Soal</a><a class="dropdown-item" href="#">Jawaban</a></div></div><div class="ckeditor-list"><textarea placeholder="Ketik data" name="column[content][${defaultInput}][]" class="form-control"></textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>`;
        }

        appendHTML += '<td><button class="remove-btn"><i class="kejar-close"></i></button></td></tr>';

        $('.melengkapi-tabel-input-table').append(appendHTML);
    }

    clearEditorField();

    $(e.target).find('.editor-field').each((index, element) => {
        generateEditor(index, element);
    });
});

$('#create-melengkapi-tabel').on('hide.bs.modal', function() {
    $('body').css('overflow-y', 'auto');
});
// END MELENGKAPI TABEL

// TEKS RUMPANG PG
$(document).on('click', '.answer-list-table-rmpg input[type=radio]', function(){
    radioRmpgManagement();
});
// END TEKS RUMPANG PG

// AJAX CALLBACK
function getApi(url, data, callback) {
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        dataType: "JSON",
        success: function (response) {
            callback(response);
        },
        error: function() {
            alert('Terjadi kesalahan, silahkan muat ulang halaman!');
        }
    });
}
// END AJAX CALLBACK

// EDIT MODAL
// Pilihan Ganda
$('#update-pilihan-ganda').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=question]').val(response.question);
        modal.find('textarea[name=explanation]').val(response.explanation);

        var html = ``;
        for (var index = 0; index < Object.keys(response.choices).length; index++) {
            html += `
            <tr>
                <td>
                    <div class="radio-group">
                        <input type="radio" name="answer" value="${index}" ${ String.fromCharCode(parseInt(65 + index)) === response.answer ? 'checked' : '' }>
                        <i class="kejar-belum-dikerjakan"></i>
                    </div>
                </td>
                <td>
                    <div class="ckeditor-group ckeditor-list">
                        <textarea name="choices[${index}]" class="editor-field" placeholder="Ketik pilihan jawaban ${index + 1}" ck-type="pilihan-ganda" required>${response.choices[String.fromCharCode(parseInt(65 + index))]}</textarea>
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
                    <button class="remove-btn" type="button">
                        <i class="kejar-close"></i>
                    </button>
                </td>
            </tr>`;
        }

        modal.find('table').html(html);

        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });

        setTimeout(() => {
            radioPgManagement();
        }, 50);
    });
});
// End Pilihan Ganda

// Menceklis Daftar
$('#update-menceklis-daftar').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=question]').val(response.question);
        modal.find('textarea[name=explanation]').val(response.explanation);

        var html = ``;
        for (var index = 0; index < Object.keys(response.choices).length; index++) {
            html += `
            <tr>
                <td>
                    <div class="check-group">
                        <input type="checkbox" name="answer[]" value="${index}" ${ response.answer.includes(String.fromCharCode(parseInt(65 + index))) ? 'checked' : '' }>
                        <i class="kejar-belum-dikerjakan"></i>
                    </div>
                </td>
                <td>
                    <div class="ckeditor-group ckeditor-list">
                        <textarea name="choices[${index}]" class="editor-field editor-field" placeholder="Ketik pilihan jawaban ${index + 1}" ck-type="menceklis-daftar" required>${ response.choices[String.fromCodePoint(65 + index)] }</textarea>
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
                    <button class="remove-btn" type="button">
                        <i class="kejar-close"></i>
                    </button>
                </td>
            </tr>`;
        }

        modal.find('table').html(html);

        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });

        setTimeout(() => {
            checkBoxMdManagement('check');
        }, 50);
    });
});
// End Menceklis Daftar

// Benar Salah
$('#update-benar-salah').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=keterangan_soal]').val(response.question);
        modal.find('textarea[name=pembahasan]').val(response.explanation);
        
        var html = ``;
        for (var index = 1; index <= Object.keys(response.choices).length; index++) {
            html += `
            <tr>
                <td>
                    <div class="ckeditor-list">
                        <textarea name="pertanyaan[]" class="editor-field" placeholder="Ketik pernyataan ${index}">${response.choices[index].question}</textarea>
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
                    <input type="hidden" name="status_pertanyaan[]" value="${response.choices[index].answer === true ? 'Benar' : 'Salah' }">
                    <div class="dropdown custom-dropdown">
                        <button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="dropdown-status text-dark">
                                ${ response.choices[index].answer === true ? 'Benar' : 'Salah' }
                            </span>
                            <i class="kejar-dropdown"></i>
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Benar</a>
                            <a class="dropdown-item" href="#">Salah</a>
                        </div>
                    </div>
                    <button class="remove-btn ${Object.keys(response.choices).length > 1 ? '' : 'd-none'}"><i class="kejar-close"></i></button>
                </td>
            </tr>`;
        }

        modal.find('table').html(html);

        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });
});
// End Benar Salah

// Ya Tidak
$('#update-ya-tidak').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=keterangan_soal]').val(response.question);
        modal.find('textarea[name=pembahasan]').val(response.explanation);
        console.log(response);

        var html = ``;
        for (var index = 1; index <= Object.keys(response.choices).length; index++) {
            html += `
            <tr>
                <td>
                    <div class="ckeditor-list">
                        <textarea name="question[]" class="editor-field" placeholder="Ketik pernyataan ${index}">${response.choices[index].question}</textarea>
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
                    <input type="hidden" name="answer[]" value="${ response.choices[index].answer === 'yes' ? 'Ya' : 'Tidak' }">
                    <div class="dropdown custom-dropdown">
                        <button class="btn btn-light dropdown-toggle text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="dropdown-status text-dark">
                                ${ response.choices[index].answer === 'yes' ? 'Ya' : 'Tidak' }
                            </span>
                            <i class="kejar-dropdown"></i>
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="">
                            <a class="dropdown-item" href="#">Ya</a>
                            <a class="dropdown-item" href="#">Tidak</a>
                        </div>
                    </div>
                    <button class="remove-btn"><i class="kejar-close"></i></button>
                </td>
            </tr>
            `;
        }

        modal.find('table').html(html);

        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });


});
// End Ya Tidak

// Mengurutkan
$('#update-mengurutkan').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name="question[question]"]').val(response.question);
        modal.find('textarea[name="question[description]"]').val(response.explanation);

        var html = ``;
        for (var index = 1; index <= Object.keys(response.choices).length; index++) {
            html += `
            <tr>
                <td>
                    <div class="num-group">
                        <input type="hidden" name="answer[${index - 1}][key]" value="${index}">
                        ${index}
                    </div>
                </td>
                <td>
                    <div class="ckeditor-group ckeditor-list">
                        <textarea name="answer[${index - 1}][description]" class="editor-field" placeholder="Ketik pernyataan/kalimat urutan ${index}" ck-type="mengurutkan">${ response.choices[index].question }</textarea>
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
            `;
        }

        modal.find('table').html(html);
    
        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });

});
// End Mengurutkan

// Memasangkan
$('#update-memasangkan').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=question]').val(response.question);
        modal.find('textarea[name=explanation]').val(response.explanation);

        var html = ``;
        for (var index = 0; index <= Object.keys(response.choices).length; index++) {
            html += `
            <tr>
                <td>
                    <div class="num-group">${index + 1}</div>
                </td>
                <td>
                    <div class="ckeditor-group ckeditor-list mb-3">
                        <textarea name="answer[statement][{{ $i }}]" class="editor-field" placeholder="Ketik pernyataan ${index + 1}" ck-type="memasangkan">${ response.choices[0][String.fromCharCode(parseInt(65 + index))] }</textarea>
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
                    <div class="ckeditor-group ckeditor-list">
                        <textarea name="answer[setstatement][{{ $i }}]" class="editor-field" placeholder="Ketik pasangan pernyataan ${index + 1}" ck-type="memasangkan">${ response.choices[1][response.answer[String.fromCharCode(parseInt(65 + index))]] }</textarea>
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
                    <button class="remove-btn" type="button">
                        <i class="kejar-close"></i>
                    </button>
                </td>
            </tr>
            `;
        }

        modal.find('table').html(html);
    
        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });

});
// End Memasangkan

// Merinci
$('#update-merinci').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=question]').val(response.question);
        modal.find('textarea[name=explanation]').val(response.explanation);

        var html = ``;
        for (var index = 0; index < Object.keys(response.choices).length; index++) {
            html += `
            <tr>
                <td>
                    <textarea name="answer[]" hidden>${ response.choices[index] }</textarea>
                    <div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik jawaban ${index + 1}">${response.choices[index]}</div>
                </td>
                <td>
                    <button class="remove-btn ${ Object.keys(response.choices).length < 3 ? 'd-none' : '' }" type="button">
                        <i class="kejar-close"></i>
                    </button>
                </td>
            </tr>`;
        }

        modal.find('table').html(html);
    
        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });

});
// End Merinci

// Esai
$('#update-esai').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=question]').val(response.question);
        modal.find('textarea[name=answer]').val(response.answer);
        modal.find('textarea[name=explanation]').val(response.explanation);
    
        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });

});
// End Esai

// Isian Bahasa
$('#update-isian-bahasa').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=question]').val(response.question);
        modal.find('textarea[name=explanation]').val(response.explanation);

        var html = ``;
        for (var index = 0; index < Object.keys(response.answer).length; index++) {
            html += `
            <tr>
                <td colspan="${ Object.keys(response.answer < 2 ? '2' : '' )  }">
                    <input type="hidden" name="answer[${index}]" value="${response.answer[index]}">
                    <div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik alternatif jawaban ${index + 1}">${ response.answer[index] }</div>
                </td>
                <td class="${ Object.keys(response.answer) < 2 ? 'd-none' : '' }">
                    <button class="remove-btn" type="button">
                        <i class="kejar-close"></i>
                    </button>
                </td>
            </tr>
            `;
        }

        modal.find('table').append(html);
    
        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });

});
// End Isian Bahasa

// Isian Matematika
$('#update-isian-matematika').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=keterangan_soal]').val(response.question);
        modal.find('textarea[name=pembahasan]').val(response.explanation);

        var html = ``;
        for (var index = 0; index < Object.keys(response.answer).length; index++) {
            html += `
            <tr>
                <td>
                    <div class="ckeditor-list">
                        <textarea name="first[]" class="editor-field" placeholder="Ketik awalan">${ response.choices.first[index] ?? '' }</textarea>
                        <div class="ckeditor-btn-group ckeditor-btn-1 d-none">
                            <button type="button" class="bold-btn" title="Bold (Ctrl + B)">
                                <i class="kejar-bold"></i>
                            </button>
                            <button type="button" class="italic-btn" title="Italic (Ctrl + I)">
                                <i class="kejar-italic"></i>
                            </button>
                            <button type="button" class="photo-btn" title="Masukkan foto">
                                <i class="kejar-photo"></i>
                            </button>
                        </div>
                    </div>
                </td>
                <td>
                    <textarea name="answer[]" class="_isian_matematika_input_answer" placeholder="Ketik jawaban">${ response.answer[index] ?? '' }</textarea>
                </td>
                <td>
                    <div class="ckeditor-list">
                        <textarea name="last[]" class="editor-field" placeholder="Ketik akhiran">${ response.choices.last[index] ?? '' }</textarea>
                        <div class="ckeditor-btn-group ckeditor-btn-1 d-none">
                            <button type="button" class="bold-btn" title="Bold (Ctrl + B)">
                                <i class="kejar-bold"></i>
                            </button>
                            <button type="button" class="italic-btn" title="Italic (Ctrl + I)">
                                <i class="kejar-italic"></i>
                            </button>
                            <button type="button" class="photo-btn" title="Masukkan foto">
                                <i class="kejar-photo"></i>
                            </button>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="remove-btn"><i class="kejar-close"></i></button>
                </td>
            </tr>
            `;
        }

        modal.find('table').html(html);
    
        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });

});
// End Isian Matematika

// Melengkapi Tabel
$('#update-melengkapi-tabel').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=keterangan_soal]').val(response.question);
        modal.find('textarea[name=pembahasan]').val(response.explanation);

        $(e.target).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
        $('#create-melengkapi-tabel-column').find('input[name="column_amount"]').val(response.choices.header.length);
        var headerHTML = `<tr>`;
        for (let h = 0; h < response.choices.header.length; h++) {
            headerHTML += `<td><input type="text" placeholder="Ketik judul kolom" name="header[]" value="${response.choices.header[h]}" class="form-control"></td>`;
        }


        headerHTML += `<td></td></tr>`;
        $(e.target).find('.melengkapi-tabel-input-table').html(headerHTML);
        var editorIndex = 2;
        for (let defaultInput = 0; defaultInput < Object.keys(response.choices.body).length; defaultInput++) {
            var appendHTML = `<tr data-row="${defaultInput}">`;

                for (let columnBody = 0; columnBody < response.choices.body[defaultInput].length; columnBody++) {
                    appendHTML += `<td>
                        <input type="hidden" name="column[status][${defaultInput}][]" value="${response.choices.body[defaultInput][columnBody].type === 'question' ? 'Soal' : 'Jawaban'}" />
                        <div class="dropdown custom-dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="dropdown-status">${response.choices.body[defaultInput][columnBody].type === 'question' ? 'Soal' : 'Jawaban'}</span><i class="kejar-dropdown"></i></button>
                            <div class="dropdown-menu w-100">
                                <a class="dropdown-item" href="#">Soal</a>
                                <a class="dropdown-item" href="#">Jawaban</a>
                            </div>
                        </div>
                        <div class="ckeditor-list">
                            <textarea placeholder="Ketik data" name="column[content][${defaultInput}][]" class="form-control ${response.choices.body[defaultInput][columnBody].type === 'answer' ? 'input-valid' : 'editor-field' }" ${ response.choices.body[defaultInput][columnBody].type === 'question' ? 'data-index="' + parseInt(editorIndex++) + '"' : '' }>${response.choices.body[defaultInput][columnBody].value}</textarea>
                            <div class="ckeditor-btn-group ckeditor-btn-1 d-none">
                                <button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button>
                            </div>
                        </div>
                    </td>`;
                }

                appendHTML += '<td><button class="remove-btn"><i class="kejar-close"></i></button></td></tr>';

                $('.melengkapi-tabel-input-table').append(appendHTML);
        }
    
        $(e.currentTarget).find('.melengkapi-tabel-input-table .editor-field').each((index, element) => {
            generateEditor($(element).data('index'), element);
        });
    });

});
// End Melengkapi Tabel

// Teks Rupang
$('#update-teks-rumpang-pg').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=question]').val(response.question);
        modal.find('textarea[name=explanation]').val(response.explanation);

        var elementGroup = '';
        var numberChoices = 1;
        var firstRumpang = modal.find('.bagian-rumpang').eq(0);
        for (var i = 0; i < response.choices.length; i++) {
            if (i == 0) {
                var dataElement = '';
                for (var j = 0; j < Object.keys(response.choices[i].choices).length; j++) {
                    var checkedRadio = response.answer[i] == String.fromCharCode(parseInt(65 + j)) ? 'checked' : '';
                    if (Object.keys(response.choices[i].choices).length > 2) {
                        dataElement += '<tr><td><div class="radio-group"><input type="radio" name="choices['+ i +'][answer]" value="'+ j +'" '+ checkedRadio +'><i class="kejar-belum-dikerjakan"></i></div></td><td><textarea name="choices['+ i +'][description][]" hidden>'+ response.choices[i].choices[String.fromCharCode(parseInt(65 + j))] +'</textarea><div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik pilihan jawaban '+ parseInt(j + 1) +'">'+ response.choices[i].choices[String.fromCharCode(parseInt(65 + j))] +'</div></td><td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td></tr>';
                    } else {
                        dataElement += '<tr><td><div class="radio-group"><input type="radio" name="choices['+ i +'][answer]" value="'+ j +'" '+ checkedRadio +'><i class="kejar-belum-dikerjakan"></i></div></td><td><textarea name="choices['+ i +'][description][]" hidden>'+ response.choices[i].choices[String.fromCharCode(parseInt(65 + j))] +'</textarea><div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik pilihan jawaban '+ parseInt(j + 1) +'">'+ response.choices[i].choices[String.fromCharCode(parseInt(65 + j))] +'</div></td></tr>';
                    }
                }
                firstRumpang.find('.answer-list-table-rmpg').html(dataElement);
            } else {
                var teksLanjutanTd1 = '<td><div class="ckeditor-group ckeditor-list"><textarea class="textarea-field editor-field" name="choices['+ numberChoices +']" placeholder="Ketik teks" ck-type="teks-rumpang-pg">'+ response.choices[i].question +'</textarea><div class="ckeditor-btn-group ckeditor-btn-1 d-none"><button type="button" class="bold-btn" title="Bold (Ctrl + B)"><i class="kejar-bold"></i></button><button type="button" class="italic-btn" title="Italic (Ctrl + I)"><i class="kejar-italic"></i></button><button type="button" class="underline-btn" title="Underline (Ctrl + U)"><i class="kejar-underlined"></i></button><button type="button" class="bullet-list-btn" title="Bulleted list"><i class="kejar-bullet"></i></button><button type="button" class="number-list-btn" title="Number list"><i class="kejar-number"></i></button><button type="button" class="photo-btn" title="Masukkan foto"><i class="kejar-photo"></i></button></div></div></td>';
                var teksLanjutanTd2 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
                elementGroup += '<div class="form-group ck-height-9 ckeditor-list lanjutan-teks"><label>Lanjutan Teks Soal</label><table class="text-list-table-rmpg" data-type="tabel-lanjut-text"><colgroup><col class="first-td"/><col class="second-td"/></colgroup><tr>'+ teksLanjutanTd1 + teksLanjutanTd2 +'</tr></table></div>';
                numberChoices++;
                if (Object.keys(response.choices[i].choices).length > 0) {
                    var bagianRumpangRow = '';
                    for (var j = 0; j < Object.keys(response.choices[i].choices).length; j++) {
                        var checkedRadio = response.answer[i] == String.fromCharCode(parseInt(65 + j)) ? 'checked' : '';
                        var bagianRumpangTd1 = '<td><div class="radio-group"><input type="radio" name="choices['+ numberChoices +'][answer]" value="'+ j +'" '+ checkedRadio +'><i class="kejar-belum-dikerjakan"></i></div></td>';
                        var bagianRumpangTd2 = '<td><textarea name="choices['+ numberChoices +'][description][]" hidden>'+ response.choices[i].choices[String.fromCharCode(parseInt(65 + j))] +'</textarea><div contenteditable="true" class="answer-field disable-editor" placeholder="Ketik pilihan jawaban '+ parseInt(j + 1) +'">'+ response.choices[i].choices[String.fromCharCode(parseInt(65 + j))] +'</div></td>';
                        if (Object.keys(response.choices[i].choices).length > 2) {
                            var bagianRumpangTd3 = '<td><button class="remove-btn" type="button"><i class="kejar-close"></i></button></td>';
                        }
                        bagianRumpangRow += '<tr>'+ bagianRumpangTd1 + bagianRumpangTd2 + bagianRumpangTd3 +'</tr>';
                    }
                    elementGroup += '<div class="form-group bagian-rumpang"><div class="d-flex justify-content-between align-items-start"><div><label>Jawaban</label><p>Semua alternatif jawaban dianggap benar.</p></div><button class="remove-btn" type="button" data-type="bagian-rumpang"><i class="kejar-close"></i></button></div><table class="answer-list-table-rmpg" data-type="tabel-rumpang-pg">'+ bagianRumpangRow +'</table><button class="btn btn-add border-0 pl-0 add-btn" type="button" data-type="jawaban-rumpang-pg"><i class="kejar-add"></i> Tambah Pilihan Jawaban</button></div>';
                    numberChoices++;
                }
            }
        }
        $(elementGroup).insertAfter(firstRumpang);
    
        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });

        setTimeout(function(){ radioRmpgManagement(); }, 50);
        addTypeRmpg(modal.find('.add-btn[data-type=next-rumpang-pg]'));
    });

});
// End Teks Rumpang

// Template
$('#update-').on('shown.bs.modal', function(e) {
    var url = $(e.relatedTarget).data('url');
    var data = [];
    var modal = $(e.currentTarget);

    clearEditorField();

    // Setting The URL to Form
    modal.find('form').attr('action', url);

    getApi(url, data, (response) => {
        modal.find('textarea[name=question]').val(response.question);
        modal.find('textarea[name=explanation]').val(response.explanation);

        var html = ``;
        for (var index = 0; index < Object.keys(response.choices).length; index++) {

        }

        modal.find('table').html(html);
    
        $(e.currentTarget).find('.editor-field').each((index, element) => {
            generateEditor(index, element);
        });
    });

});
// End Template

// END EDIT MODAL