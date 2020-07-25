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
        $.each(elements, function(key, value) {
            if (key == 0 && elements.length > 1) {
                $(value).find('.btn-icon:first').css('display', 'none');
                $(value).find('.btn-icon:last').css('display', 'grid');
            } else if (key == (elements.length - 1) && elements.length > 1) {
                $(value).find('.btn-icon:first').css('display', 'grid');
                $(value).find('.btn-icon:last').css('display', 'none');
            } else if (elements.length > 1) {
                $(value).find('.stage-order-buttons button').css('display', 'grid');
            } else{
                $(value).find('.stage-order-buttons button').css('display', 'none');
            }
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

    // AJAX Ordering
    function orderUpdate(id, order){
        $.ajax({
            type: "POST",
            url: "{{ url('admin/'. $game['uri'] . '/') }}/stages/" + id + "/order",
            data: {
                "_method": "PATCH",
                "_token": "{{ csrf_token() }}",
                "order": order
            },
            dataType: "JSON",
            success: function (response) {
                console.log(response);
            }
        });
    }