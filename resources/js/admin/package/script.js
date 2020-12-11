// Ceking Element
checkElements();
function checkElements(){
    var elements = $('.list-group .list-group-item');
    $.each(elements, function(key, value) {
        $(value).find('.order-number').text(`Paket ${key + 1} : `);
    });
}

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

$('[data-toggle="popover"]').popover();
// Copying the id of Package
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


// Function for Checking AJAX Orderin

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

$('.kejar-link').click(function (e) { 
    e.preventDefault();
    textToClipboard($(this).data('id'));
});

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

// AJAX Ordering
function orderUpdate(id, order){
    $.ajax({
        type: "POST",
        url: $('.list-group').data('url') + '/' + id + '/order',
        data: {
            "_method": "PATCH",
            "_token": $('.list-group').data('token'),
            "order": order
        },
        beforeSend: function() {
            showLoader();
        },
        dataType: "JSON",
        success: function (response) {
            hideLoader();
        },
    });
}