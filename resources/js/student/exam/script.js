
$(document).ready(function(){

    var questionsList = $('.question-list');
    var questions = $('.question-list .question-item');
    var timer = $('.question-list').data('timer') * 1000;
    var i = 0;

    startQuestion();
    function startQuestion() {
        var questions = $('.question-list .question-item');
        var el = $(questions[i]);

        $('.timer-length').css({'background' : '#4DC978', 'width' : '100%'});
        $(el).find('.btn-next').addClass('btn-next-disabled').prop('disabled', true);
        $(el).find('.answer-input').css({'border-bottom-color': '#A6D1FF'}).val('').removeAttr('readonly').focus();
        $(el).find('.notification-success').css({'display' : 'none'});
        $(el).find('.notification-failed').css({'display' : 'none'});
        $(el).find('.toeic-description').css('display', 'block');
        $(el).find('.toeic-notification').css({'display' : 'none'});

        countDown();
    }

    function countDown() {
        $('.timer-length').css({'background': '#4DC978', 'width' : '100%'});
        $('.timer-length').animate({
            width: '0%'
        }, timer, function(){
            checkAnswer();
        });
        timerGetStarted();
    }

    function checkAnswer() {
        var questions = $('.question-list .question-item');
        var el = $(questions[i]);
        var urlCheck = $('.question-list').data('check');
        $(el).find('.answer-input').attr('readonly', true);
        $(el).find('.btn-next').addClass('btn-next-disabled').prop('disabled', true);
        var answerInput = $(el).find('.answer-input').val();
        answerInput = answerInput === '' ? 'null' : answerInput;

        $.ajax({
            type: "POST",
            url: urlCheck,
            data: {
                '_token' : $('input[name="_token"]').val(),
                'id' : $(el).data('id'),
                'task_id' : $('.question-list').data('task'),
                'answer' : answerInput,
                'repeatance' : $(el).find('.answer-input').data('status'),
            },
            dataType: "JSON",
            success: function (response) {

                if(response.status === true){
                    rightAnswer();
                } else{
                    wrongAnswer(response.answer);
                }
            },
            error: function () {
                alert('Ups! Sepertinya ada yang salah.');
                location.reload();
            }
        });
    }

    function wrongAnswer(answer) {
        var questions = $('.question-list .question-item');
        var el = $(questions[i]);

        $('.timer-length').css({'background': '#FF4343'});
        $(el).find('.answer-input').css({'border-bottom-color': '#FF4343'});
        $(el).find('.toeic-description').css('display', 'none');
        $(el).find('.toeic-notification').css({'display' : 'block'});
        $(el).find('.notification-failed').css({'display': 'block'});
        $(el).find('.seharusnya').css({'display': 'block'}).text(answer);
        setTimeout(() => {
            var repetancePrev = $(el).data('repeatance');

            var repeatanceAtLast = $('.question-list .question-item').last().data('repeatance');

            if (repeatanceAtLast < 2) {
                questionsList.append(el.clone(false));

                var last = $('.question-list .question-item').last();
                var repeatance = $(last).data('repeatance');
                $(last).attr('data-repeatance', repeatance + 1).css({'display' : 'none'});
                $(last).find('.answer-input').removeAttr('name');
                $(last).find('.answer-input').attr('data-status', true);
                if (repeatance + 1 > 2) { $(last).remove(); }
            }

            nextQuestion();
        }, 1000);
    }

    function rightAnswer() {
        var questions = $('.question-list .question-item');

        $(questions[i]).find('.toeic-description').css('display', 'none');
        $(questions[i]).find('.toeic-notification').css({'display' : 'block'});
        $(questions[i]).find('.notification-success').css({'display': 'block'});
        $(questions[i]).find('.answer-input').attr('data-status', 'true');

        setTimeout(() => {
            if (i < (questions.length - 1)) {
                nextQuestion();
            } else{
                finish();
            }
        }, 1000);
    }

    function nextQuestion() {
        var questions = $('.question-list .question-item');
        if (i < questions.length - 1) {
            $(questions[i]).css({'display' : 'none'});

            i += 1;
            $(questions[i]).css({'display' : 'block'});
            $('.number').text($(questions[i]).data('number'));

            startQuestion();
        } else{
            finish();
        }
    }

    $('body').on('keyup', '.answer-input', function(e){
        var btnNext = $(this).parents('.question-item').find('.btn-next');
        if (e.which !== 13) {
            if ($(this).val() != '') {
                $(btnNext).removeClass('btn-next-disabled').prop('disabled', false);
            } else{
                $(btnNext).addClass('btn-next-disabled').prop('disabled', true);
            }
        }
    });

    $('body').on('keyup', '.answer-input', function(e){
        if (e.which === 13) {
            $(this).parents('.question-item').find('.btn-next').click();
            $(this).parents('.question-item').find('.btn-next').prop('disabled', true);
        }
    });

    $('body').on('click', '.btn-next', function () {
        $(this).prop('disabled', true);
        $('.timer-length').stop();
        checkAnswer();
    });

    $('#exitExamModal').on('show.bs.modal', event => {
        // Use above variables to manipulate the DOM
        // $('.timer-length').stop();
        timerGetStoped();
    });

    $('#exitExamModal').on('hide.bs.modal', event => {
        $('.timer-length').animate({
            width: '0%'
        }, timer, function(){
            checkAnswer();
        });
    });

    function timerGetStoped() {
        $('.timer-length').stop();
    }

    function timerGetStarted() {
        
    }

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
        console.log(form.html());
        $(form).submit();
    }
});
