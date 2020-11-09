var timer = $('.question-list').data('timer') * 1000;

$(document).on('click', '._benar_salah_radio', (e) => {
    var radios = $(e.target).parents('.question-group').find('._benar_salah_radio').length;
    var radiosQuestions = radios / 2;

    if ($(e.target).parents('.question-group').find('._benar_salah_radio:checked').length >= radiosQuestions) {
        $(e.target).parents('.question-group').find('._check_button').removeClass('disabled');
    } else {
        $(e.target).parents('.question-group').find('._check_button').addClass('disabled');
    }
});

$(document).on('click', '._check_button', function(e) {
    e.preventDefault();

    checkAnswer();
});

$('.question-list').on('click', '._next_button', function(e) {
    e.preventDefault();
    
    nextQuestion(e);
});

function nextQuestion(e) {
    countDown();

    $(e.target).parents('.question-group').css('display', 'none');
    $('.active.number').text($(e.target).parents('.question-group').next().data('number'));
    $(e.target).parents('.question-group').next().css('display', 'block');
}

function countDown() {
    $('.timer-length').css({'background': '#4DC978', 'width' : '100%'});
    $('.timer-length').animate({
        width: '0%'
    }, timer, function(){
        checkAnswer();
    });
}

function countDownStop() {
    $('.timer-length').stop(); 
}

function checkAnswer() {
    countDownStop();

    var parentElement = $('.question-group:visible');
    
    // Check if the current question type is benar_salah
    if ($(parentElement).data('type') === 'benar_salah') {
        var arrayAnswers = {};
        let type = $(parentElement).data('type');
    
        for (let i = 1; i <= $(parentElement).find('input[type="radio"]').length / 2; i++) {
            arrayAnswers[`${i}`] = {  
                                    'answer' : $(parentElement).find('input[name="answer[' + i + ']"]:checked').val() === "benar" ? true : $(parentElement).find('input[name="answer[' + i + ']"]:checked').val() === 'salah' ? false : null,
                                    'question' : $($(parentElement).find('._benar_salah_question')[i - 1]).html().trim() ?? null,
                                };
        }

        let data = {
            'id' : $(parentElement).data('id'),
            'task_id' : $('.question-list').data('task'),
            'answer' : arrayAnswers,
            'repeatance' : $(parentElement).data('repeat'),
            'type': type
        }

        // Send ajax request
        AjaxRequest(data, (res) => {
            var html = '';
            for (let i = 0; i < res.answer.length; i++) {
                html += `<div class='d-flex flex-wrap flex-nowrap justify-content-between align-items-center _benar_salah_right_answers_item'><div class='_benar_salah_question_answer'>${res.answer[i].question}</div><div class='_benar_salah_options_right_answer'>${res.answer[i].answer === true ? 'Benar' : 'Salah'}</div></div>`;
            }
        
            $(parentElement).find('._benar_salah_right_answers').html(html);
            $(parentElement).find('._benar_salah_session').first().css('display', 'block');

            $(parentElement).find('._benar_salah_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._benar_salah_radio').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                console.log('salah');
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    $(parentElement).attr('data-repeatance', $(parentElement).data('repeatance') + 1);
    
    $(parentElement).first().find('._question_button').removeClass('_check_button disabled');

    
}

function buttonFunction(parentElement) {
    if ($(parentElement).next().length > 0) {
        $(parentElement).find('._question_button').addClass('_next_button').html('LANJUT <i class="kejar kejar-next"></i>');
    } else {
        $(parentElement).find('._question_button').addClass('_soal_cerita_finish').html('SELESAI <i class="kejar kejar-next"></i>');
    }
}

function rightAnswer() {
}

function wrongAnswer() {
    countDownStop();

    var currentQuestion = $('.question-group:visible');

    if ($(currentQuestion).data('type') === 'benar_salah') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('._benar_salah_options').each((index, element) => {
                $(element).find('input').prop('disabled', false).prop('checked', false);
                $(element).find('._answer_salah_option').prop('id', 'answer_salah_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']').parent().find('label').prop('for', 'answer_salah_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']');
                $(element).find('._answer_benar_option').prop('id', 'answer_benar_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']').parent().find('label').prop('for', 'answer_benar_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']');
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._benar_salah_session').css('display', 'none');
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('disabled _check_button');
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

}

$(document).ready(() => {
    countDown();
});

function AjaxRequest(data, res) {
    var urlCheck = $('.question-list').data('check');
    
    data['_token'] = $('input[name="_token"]').val();
    
    $.ajax({
        type: "POST",
        url: urlCheck,
        data: data,
        dataType: "JSON",
        success: function (response) {
            res(response);
        },
        error: function () {
            alert('Ups! Sepertinya ada yang salah. Silahkan ulangi kembali dengan me-refresh halaman ini!');
        }
    });
}

$(document).on('click', '#question-list ._soal_cerita_finish', function() {
    finish(); 
});

function finish() {
    var form = $('#question-list');
    $(form).prepend('<input class="d-none" name="_token" value="' + $('input[name="_token"]').val() +'">');
    $(form).submit();
}