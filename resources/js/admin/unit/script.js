$(function () {
    $('[data-toggle="popover"]').popover();
});

$(document).on('dblclick', '.edit-title', function() {
    $('#editTitle').modal('show');
});

$(document).on('dblclick', '.edit-description', function() {
    $('#editDescription').modal('show');
});

// Ceking Element
checkElements();
function checkElements(){
    var elements = $('.list-group .list-group-item');
    $.each(elements, function(key, value) {
        $(value).find('.order-number').text(`Unit ${key + 1} : `);
    });
}

$(document).on('click', '.kejar-link', function(e) {
    e.preventDefault();
    var thisElement = $(this);
    var roundId = $(this).attr('data-id');
    setTimeout( function() {
        thisElement.popover('hide');
    }, 1000);
    textToClipboard(roundId);
});

$(document).on('click', '.copy-id', function() {
    var stageId = $(this).attr('data-id');
    textToClipboard(stageId);
    var thisElement = $(this);
    setTimeout( function() {
        thisElement.popover('hide');
    }, 1000);
});

function textToClipboard (text) {
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
}


$('#createRoundModal').on('show.bs.modal', function() {
    $('#uploadRoundModal').modal('hide');
});

$('#createRoundModal').on('hide.bs.modal', function() {
    $('#uploadRoundModal').modal('show');
});

// Ordering Package Buttons
$('.list-group-item').on('click', '.btn-icon-top', function(){
    var el = $(this).parents('.list-group-item');
    var elPrev = el.prev();
    el.insertBefore(elPrev);
    checkElements();
    ordering(el, elPrev);
});

$('.list-group-item').on('click', '.btn-icon-bottom', function(){
    var el  = $(this).parents('.list-group-item');
    var elNext = el.next();
    el.insertAfter(elNext);
    checkElements();
    ordering(el, elNext);
});


function ordering(mainEl, minorEl){
    var elements = $('.list-group .list-group-item');
    var mainElId = $(mainEl).data('id');
    var minorElId = $(minorEl).data('id');

    $.each(elements, function (key, value) {
        if ($(value).data('id') == mainElId){
        orderUpdate(mainElId, (key + 1));
        } else if ($(value).data('id') == minorElId){
        orderUpdate(minorElId, (key + 1));
        }
    });
}

// AJAX Ordering
function orderUpdate(id, order){
    $.ajax({
        type: "POST",
        url: $('.list-group').data('url'),
        data: {
            "_token": $('.list-group').data('token'),
            "_method": "PATCH",
            "order": order,
            "id": id
        },
        dataType: "JSON",
        success: function (response) {
            
        }
    });
}