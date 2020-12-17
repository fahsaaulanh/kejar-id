const { repeat } = require("lodash");

$(document).ready(function(){

    var i = 0;
    var timer = $('.question-list').data('timer') * 1000;

    startQuestion();

    function startQuestion() {
        var questions = $('.question-list .question-item');
        $('.number').text($(questions[i]).data('number'));
        $(questions[i]).find('.answer-status').addClass('d-none').removeClass('salah benar');
        $(questions[i]).find('.answer-input').val('').prop('readonly', false).removeClass('benar salah').focus();
        $(questions[i]).find('.btn-check').prop('disabled', true).html('CEK JAWABAN <i class="kejar kejar-next"></i>');
        $(questions[i]).find('.pembahasan').css('display', 'none');
        $(questions[i]).attr('data-repeatance', $(questions[i]).data('repeatance') + 1);
        $(questions[i]).find('.btn').prop('disabled', true).removeClass('btn-lanjut').addClass('btn-check').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
        countDown();
    }

    function checkAnswer() {
        var questions = $('.question-list .question-item');
        $(questions[i]).find('.answer-input').prop('readonly', true).focus();
        $(questions[i]).find('.btn-check').text('Mengecek ...');
        $('.timer-length').stop();

        var urlCheck = $('.question-list').data('check');

        $.ajax({
            type: "POST",
            url: urlCheck,
            data: {
                '_token' : $('input[name="_token"]').val(),
                'id' : $(questions[i]).data('id'),
                'task_id' : $('.question-list').data('task'),
                'answer' : $(questions[i]).find('.answer-input').val(),
                'repeatance' : $(questions[i]).find('.answer-input').data('status'),
            },
            dataType: "JSON",
            success: function (response) {
                if(response.status === true){
                    rightAnswer();
                } else{
                    wrongAnswer();
                    repeatQuestion();
                }

                $(questions[i]).find('.pembahasan').css('display', 'block');
                $(questions[i]).find('.pembahasan').find('.explanation-text').html(response.explanation);

                let alternativeAnswers = '';

                if (typeof(response.answer) !== 'string') {
                    $.each(response.answer, function () {
                        alternativeAnswers += '<li><i class="kejar-soal-benar"></i>' + this + '</li>';
                    });
                } else {
                    alternativeAnswers = '<li><i class="kejar-soal-benar"></i>' + response.answer + '</li>';
                }

                $(questions[i]).find('.pembahasan').find('.alternative-answers ul').html(alternativeAnswers);

                if (($('.question-list .question-item').length - 1) !== i) {
                    $(questions[i]).find('.btn-check').prop('disabled', false);
                    $(questions[i]).find('.btn-check').blur();
                    $(questions[i]).find('.btn-check').html('LANJUT <i class="kejar kejar-next"></i>').addClass('btn-lanjut');
                    $(questions[i]).find('.btn-check').removeClass('btn-check');
                } else {
                    $(questions[i]).find('.btn-check').html('SELESAI <i class="kejar kejar-next"></i>');
                    $(questions[i]).find('.btn-check').removeClass('btn-lanjut btn-check').addClass('btn-selesai');
                }
            },
            error: function () {
                alert('Ups! Sepertinya ada yang salah.');
                location.reload();
            }
        });

    }

    function nextQuestion() {
        var questions = $('.question-list .question-item');
        $(questions[i]).find('.btn-lanjut').prop('disabled', true);
        $(questions[i]).find('.btn-lanjut').removeClass('btn-lanjut').addClass('btn-check').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
        $(questions[i]).find('.answer-input').val('');
        $(questions[i]).find('.pembahasan').css('display', 'none');
        $(questions[i]).css('display', 'none');
        i = i + 1;
        $(questions[i]).css('display', 'block');
        startQuestion();
    }

    function rightAnswer() {
        var questions = $('.question-list .question-item');
        $(questions[i]).find('.answer-input').addClass('benar');
        $(questions[i]).find('.answer-status').removeClass('d-none').addClass('benar').html('<i class="kejar-soal-benar"></i> Benar!');
    }

    function wrongAnswer() {
        var questions = $('.question-list .question-item');
        $(questions[i]).find('.answer-input').addClass('salah');
        $(questions[i]).find('.answer-status').removeClass('d-none').addClass('salah').html('<i class="kejar-soal-salah"></i> Salah!');
        $(questions[i]).find('.answer-input').data('status')
    }

    function repeatQuestion() {
        var questions = $('.question-list .question-item');
        if($(questions[i]).data('repeatance') < 2) {
            $('.question-list').append($(questions[i]).clone(false));
            $('.question-list .question-item').last().css('display', 'none').attr('data-repeatance', $(questions[i]).data('repeatance') + 1);
            $('.question-list .question-item').last().find('.answer-input').attr('data-status', true);
        }
    }

    function countDown() {
        $('.timer-length').css({'background': '#4DC978', 'width' : '100%'});
        $('.timer-length').animate({
            width: '0%'
        }, timer, function(){
            checkAnswer();
        });
    }

    $('body').on('keyup', '.answer-input', function(e){
        var btnCheck = $(this).parents('.question-item').find('.btn-check');
        if ($(this).val() !== ''){
            $(btnCheck).prop('disabled', false);
        } else {
            $(btnCheck).prop('disabled', true);
        }
    });

    $('body').on('click', '.btn-check', function(e) {
        e.preventDefault();
        checkAnswer();
    });

    $('body').on('click', '.btn-lanjut', function(e) {
        e.preventDefault();
        nextQuestion();
    });

    $('body').on('click', '.btn-selesai', function(e) {
        e.preventDefault();
        finish();
    });

    $('#exitExamModal').on('show.bs.modal', function() {
        $('.timer-length').stop();
    });

    $('#exitExamModal').on('hide.bs.modal', event => {
        $('.timer-length').animate({
            width: '0%'
        }, timer, function(){
            checkAnswer();
        });
    });

    $(document).on("keydown", function(e) {
        e = e || window.event;
        if (e.ctrlKey) {
            var c = e.which || e.keyCode;
            if (c == 82) {
                e.preventDefault();
                e.stopPropagation();
                $('#exitExamModal').modal('show');
            }
        }
        else if(e.which === 116)
        {
            e.preventDefault();
            $('#exitExamModal').modal('show');
        }
    });

    function finish() {
        var form = $('#question-list');
        $(form).prepend('<input class="d-none" name="_token" value="' + $('input[name="_token"]').val() +'">');
        $(form).submit();
    }
});
