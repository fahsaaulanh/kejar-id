const { includes } = require("lodash");

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

$(document).on('click', '._ya_tidak_radio', (e) => {
    var radios = $(e.target).parents('.question-group').find('._ya_tidak_radio').length;
    var radiosQuestions = radios / 2;

    if ($(e.target).parents('.question-group').find('._ya_tidak_radio:checked').length >= radiosQuestions) {
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
                html += `<div class='d-flex flex-wrap flex-nowrap justify-content-between align-items-center _ya_tidak_right_answers_item'><div class='_ya_tidak_question_answer'>${res.answer[i].question}</div><div class='_ya_tidak_options_right_answer'>${res.answer[i].answer === 'yes' ? 'Ya' : 'Tidak'}</div></div>`;
            }
            $(parentElement).find('._benar_salah_right_answers').html(html);
            $(parentElement).find('._benar_salah_session').first().css('display', 'block');

            $(parentElement).find('._ya_tidak_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._ya_tidak_radio').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }
    
    // Check if the current question type is ya_tidak
    if ($(parentElement).data('type') === 'ya_tidak') {
        var arrayAnswers = {};
        let type = $(parentElement).data('type');
    
        for (let i = 1; i <= $(parentElement).find('input[type="radio"]').length / 2; i++) {
            arrayAnswers[`${i}`] = {  
                                    'answer' : $(parentElement).find('input[name="answer[' + i + ']"]:checked').val() === "ya" ? 'yes' : ($(parentElement).find('input[name="answer[' + i + ']"]:checked').val() === 'tidak' ? 'no' : null),
                                    'question' : $($(parentElement).find('._ya_tidak_question')[i - 1]).html().trim() ?? null,
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
                html += `<div class='d-flex flex-wrap flex-nowrap justify-content-between align-items-center _ya_tidak_right_answers_item'><div class='_ya_tidak_question_answer'>${res.answer[i].question}</div><div class='_ya_tidak_options_right_answer'>${res.answer[i].answer === 'yes' ? 'Ya' : 'Tidak'}</div></div>`;
            }
        
            $(parentElement).find('._ya_tidak_right_answers').html(html);
            $(parentElement).find('._ya_tidak_session').first().css('display', 'block');

            $(parentElement).find('._ya_tidak_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._ya_tidak_radio').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    // Check if the current question type is isian_matematika
    if ($(parentElement).data('type') === 'isian_matematika') {
        var arrayAnswers = Array();
        let type = $(parentElement).data('type');
    
        $(parentElement).find('._isian_matematika_input').each((index, element) => {
            arrayAnswers.push($(element).val());
        });

        let data = {
            'id' : $(parentElement).data('id'),
            'task_id' : $('.question-list').data('task'),
            'answer' : arrayAnswers,
            'repeatance' : $(parentElement).data('repeat'),
            'type': type
        }

        // Send ajax request
        AjaxRequest(data, (res) => {
            var questionHTML = $($(parentElement).find('._isian_matematika_question')[0]).clone(false);
            $(questionHTML).find('._isian_matematika_input').each((index, element) => {
                $(element).removeClass('_isian_matematika_input').addClass('_isian_matematika_input_session')
                    .val(res.answer[index]).prop('disabled', true)
                    .removeAttr('name');
            });
        
            $(parentElement).find('._isian_matematika_right_answers').append(questionHTML);

            inputAutoWith();

            $(parentElement).find('._isian_matematika_session').first().css('display', 'block');

            $(parentElement).find('._isian_matematika_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._isian_matematika_input').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    // Check if the current question type is pilihan_ganda
    if ($(parentElement).data('type') === 'pilihan_ganda') {
        var answer = $(parentElement).find('._pilihan_ganda_answer input:checked').val() ?? null;
        let type = $(parentElement).data('type');

        let data = {
            'id' : $(parentElement).data('id'),
            'task_id' : $('.question-list').data('task'),
            'answer' : answer,
            'repeatance' : $(parentElement).data('repeat'),
            'type': type
        }

        // Send ajax request
        AjaxRequest(data, (res) => {

            var html = `
                <div>
                    ${ res.answer }
                </div>
            `;
        
            $(parentElement).find('._pilihan_ganda_right_answers').append(html);

            $(parentElement).find('._pilihan_ganda_session').first().css('display', 'block');

            $(parentElement).find('._pilihan_ganda_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._pilihan_ganda_answer input').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    // Check if the current question type is mengurutkan
    if ($(parentElement).data('type') === 'mengurutkan') {
        var arrayAnswers = {};
        let type = $(parentElement).data('type');

        let ind = 1;
        $(parentElement).find('input').each((index, data) => {
            arrayAnswers[ind++] = {
                'question' : $(data).next('._mengurutkan_question_text').html(),
                'answer' : $(data).val()
            };
        });

        let data = {
            'id' : $(parentElement).data('id'),
            'task_id' : $('.question-list').data('task'),
            'answer' : arrayAnswers,
            'repeatance' : $(parentElement).data('repeat'),
            'type': type
        }

        // Send ajax request
        AjaxRequest(data, (res) => {

            var body = ``;
            res.answer.forEach(dat => {
                body += `<div class="d-flex justify-content-start _mengurutkan_answer_item">
                    <div>${dat.answer}.</div>
                    <div>${dat.question}</div>
                </div>`;
            });

            var html = `
                <div class="_mengurutkan_answers">
                    ${body}
                </div>
            `;
        
            $(parentElement).find('._mengurutkan_right_answers').append(html);

            $(parentElement).find('._mengurutkan_session').first().css('display', 'block');

            $(parentElement).find('._mengurutkan_explanation div').html(`${res.explanation}`);

            $(parentElement).find('input').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
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

            $(cloned).find('._ya_tidak_options').each((index, element) => {
                $(element).find('input').prop('disabled', false).prop('checked', false);
                $(element).find('._answer_tidak_option').prop('id', 'answer_tidak_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']').parent().find('label').prop('for', 'answer_tidak_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']');
                $(element).find('._answer_ya_option').prop('id', 'answer_ya_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']').parent().find('label').prop('for', 'answer_ya_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']');
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._ya_tidak_session').css('display', 'none');
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('disabled _check_button');
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'ya_tidak') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('._ya_tidak_options').each((index, element) => {
                $(element).find('input').prop('disabled', false).prop('checked', false);
                $(element).find('._answer_tidak_option').prop('id', 'answer_tidak_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']').parent().find('label').prop('for', 'answer_tidak_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']');
                $(element).find('._answer_ya_option').prop('id', 'answer_ya_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']').parent().find('label').prop('for', 'answer_ya_' + $('.question-list .question-group').length + '[' + parseInt(index + 1) + ']');
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._ya_tidak_session').css('display', 'none');
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('disabled _check_button');
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'isian_matematika') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('._isian_matematika_input').each((index, element) => {
                $(element).prop('disabled', false).val('').width(40);
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._isian_matematika_session').css('display', 'none');
            $(cloned).find('._isian_matematika_session').find('._isian_matematika_question').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('disabled _check_button');
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'pilihan_ganda') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);
            var options = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];

            $(cloned).find('._pilihan_ganda_answer input').each((index, element) => {
                $(element).prop('disabled', false).removeAttr('checked')
                $(element).next('i').removeAttr('class').addClass(`kejar-${options[index]}-ellipse`);
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._pilihan_ganda_session').css('display', 'none');
            $(cloned).find('._pilihan_ganda_session').find('._pilihan_ganda_right_answers div').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('disabled _check_button');
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'mengurutkan') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('input').each((index, element) => {
                $(element).prop('disabled', false).val('');
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._mengurutkan_session').css('display', 'none');
            $(cloned).find('._mengurutkan_session').find('._mengurutkan_answers').remove();
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

// Isian Matematika
$(document).on('input', '._isian_matematika_input', (e) => {
    var count = 0;
    var parentElement = $('.question-group:visible');

    $(parentElement).find("._isian_matematika_input").each((index, element) => {
        if (element.value === "") {
            count++;
        }
    });

    if( count === 0 ) {
        $(parentElement).find('._question_button').removeClass('disabled');
    } else {
        $(parentElement).find('._question_button').addClass('disabled');
    }

    inputAutoWith();
});

inputAutoWith();

function inputAutoWith() {
    elementWidth("._isian_matematika_input");
    elementWidth("._isian_matematika_input_session");
}

function elementWidth(className) {
    var parentWidth;

    $(className).each((index, element) => {
        var defaultWith;
        if ($(document).width() <= 768) {
            defaultWith = 40;
            parentWidth = $('div.col-md-10.col-sm-12').width() - 30;
        } else {
            defaultWith = 84;
            parentWidth = $('div.col-md-10.col-sm-12').width();
        }

        $(element).width(() => {
            var inputWidth = $(element).val().length * 9 + 4 >= defaultWith ? ($(element).val().length * 9 + 4) : defaultWith;
            inputWidth = inputWidth > parentWidth ? parentWidth : inputWidth; 
            return inputWidth;
        });
    });
}
// End Isian Matematika

// Pilihan Ganda
$(document).on('click', '._pilihan_ganda_radio_answer input', function(){
    var currentELement = $('.question-group:visible');
    $(currentELement).find('._pilihan_ganda_radio_answer').each(function(){
        var iconEl = $(this).children().last();
        var parseArr = iconEl.removeClass('kejar').attr('class').split('-');
        if (iconEl.prev().is(':checked')) {
            parseArr.remove('bold').splice(2, 0, 'bold');
            iconEl.attr('class', 'kejar ' + parseArr.join('-'));
            $(currentELement).find('._question_button').addClass('active').attr('disabled', false);
        } else {
            iconEl.attr('class', 'kejar ' + parseArr.remove('bold').join('-'));
        } 
    });
});

Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
// End Pilihan Ganda

// Mengurutkan
$('.question-group').on('input', 'input[type=number]', function(){
    var currentElement = $('.question-group:visible');

    if ($(currentElement).data('type') === 'mengurutkan') {
        var inEl = 0;
        $(currentElement).find('input[type=number]').each(function(){
            if ($(this).val() === '') {
                inEl -= 1;
            } else {
                inEl += 1;
            }
        });
    
        if (inEl === $(currentElement).find('input').length) {
            $(currentElement).find('._question_button').prop('disabled', false);
        } else {
            $(currentElement).find('._question_button').prop('disabled', true);
        }
    }

});
// End Mengurutkan
