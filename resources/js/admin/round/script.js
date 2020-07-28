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

    $(document).on('click', '.sort-up', function() {
        var this_id = $(this).parents('.list-group-item').attr('data-id');
        var to_id = $(this).parents('.list-group-item').prev().attr('data-id');
        var this_element = $(this).parents('.list-group-item')
        var to_element = $(this).parents('.list-group-item').prev();
        $.ajax({
            type: "POST",
            url: $('.list-group').data('url'),
            data: {
                '_token' : $('.list-group').data('token'),
                'this_id' : this_id,
                'to_id' : to_id
            },
            success:function(data){
                to_element.insertAfter(this_element);
                numberSortCheck();
                buttonSortCheck();
            }
        });
    });

    $(document).on('click', '.sort-down', function() {
        var this_id = $(this).parents('.list-group-item').attr('data-id');
        var to_id = $(this).parents('.list-group-item').next().attr('data-id');
        var this_element = $(this).parents('.list-group-item');
        var to_element = $(this).parents('.list-group-item').next();
        $.ajax({
            type: "POST",
            url: $('.list-group').data('url'),
            data: {
                '_token' : $('.list-group').data('token'),
                'this_id' : this_id,
                'to_id' : to_id
            },
            success:function(data){
                this_element.insertAfter(to_element);
                numberSortCheck();
                buttonSortCheck();
            }
        });
    });

    function textToClipboard (text) {
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
    }

    function buttonSortCheck()
    {
        $('.sort-up').each(function() {
            $(this).prop('hidden', false);
        });
        $('.sort-down').each(function() {
            $(this).prop('hidden', false);
        });
        $('.sort-up').first().prop('hidden', true);
        $('.sort-down').last().prop('hidden', true);
    }

    buttonSortCheck();

    function numberSortCheck()
    {
        $('.list-group-item a span').each(function(number) {
            number++;
            $(this).text('Ronde ' + number);
        });
    }

    numberSortCheck();

    $('#createRoundModal').on('show.bs.modal', function() {
        $('#uploadRoundModal').modal('hide');
    });

    $('#createRoundModal').on('hide.bs.modal', function() {
        $('#uploadRoundModal').modal('show');
    });