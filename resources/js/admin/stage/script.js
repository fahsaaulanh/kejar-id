    $('#createStageModal').on('show.bs.modal', event => {
        $('#upload-stages').modal('hide');
    });

    $('#upload-stages').on('show.bs.modal', event => {
        $('#createStageModal').modal('hide');
    });

    // Ceking Element
    checkElements();
    function checkElements(){
        var elements = $('.list-group .list-group-item');
        $(elements).find('.btn-icon').each(function() {
            $(this).prop('hidden', false);
        });

        $(elements).find('.btn-icon:first').first().prop('hidden', true);
        $(elements).find('.btn-icon:last').last().prop('hidden', true);

        $.each(elements, function(key, value) {
            $(value).find('.stage-number').text('Babak ' + (key + 1));
        });
    }

    // Ordering Stage Buttons
    $('.list-group-item').on('click', '.btn-icon:first', function(){
        var el = $(this).parents('.list-group-item');
        var elPrev = el.prev();
        el.insertBefore(elPrev);
        checkElements();
        ordering(el, elPrev);
    });

    $('.list-group-item').on('click', '.btn-icon:last', function(){
        var el  = $(this).parents('.list-group-item');
        var elNext = el.next();
        el.insertAfter(elNext);
        checkElements();
        ordering(el, elNext);
    });

    $('[data-toggle="popover"]').popover();
    // Copying the id of stage
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

    // Upload File Fix

    $(document).on('change', 'input[type=file]', function(){
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');

        filename = filename == '' ? 'Pilih file' : filename;
        $(this).parents('.custom-upload').find('input[type=text]').val(filename);
    });


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
            dataType: "JSON",
            success: function (response) {
                
            }
        });
    }