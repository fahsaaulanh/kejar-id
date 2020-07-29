    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    $(document).on('dblclick', 'h2', function() {
        $('#editTitle').modal('show');
    });

    $(document).on('dblclick', 'h5, p', function() {
        $('#editDescription').modal('show');
    });

    $(document).on('click', '.kejar-ink', function(e) {
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

    $(document).on('change', 'input[name=excel_file]', function() {
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
        $('input[name=file_name]').val(filename);
    });

    $(document).on('change', 'input[name=question_file]', function() {
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
        $('input[name=question_name]').val(filename);
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

    checkElements();
    function checkElements(){
        var elements = $('.list-group .list-group-item');

        $('.sort-up').each(function() {
            $(this).prop('hidden', false);
        });

        $('.sort-down').each(function() {
            $(this).prop('hidden', false);
        });

        $('.sort-up').first().prop('hidden', true);
        $('.sort-down').last().prop('hidden', true);

        $.each(elements, function(key, value) {
            $(value).find('.order-number').text('Ronde ' + (key + 1));
        });
    }

    $('.list-group-item').on('click', '.sort-up', function(){
        var el = $(this).parents('.list-group-item');
        var elPrev = el.prev();
        el.insertBefore(elPrev);
        checkElements();
        ordering(el, elPrev);
    });

    $('.list-group-item').on('click', '.sort-down', function(){
        var el  = $(this).parents('.list-group-item');
        var elNext = el.next();
        el.insertAfter(elNext);
        checkElements();
        ordering(el, elNext);
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
            url: $('.list-group').data('url'),
            data: {
                "_token": $('.list-group').data('token'),
                "order": order,
                "id": id
            },
            dataType: "JSON",
            success: function (response) {
                
            }
        });
    }