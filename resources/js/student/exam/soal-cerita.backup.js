const { includes } = require("lodash");

var timer = $('.question-list').data('timer') * 1000;

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
                html += `<div class='d-flex flex-wrap flex-nowrap justify-content-between align-items-center _benar_salah_right_answers_item'>
                    <div class='_benar_salah_question_answer'>${res.answer[i].question}</div>
                    <div class='_benar_salah_options_right_answer'>${res.answer[i].answer === true ? 'Benar' : 'Salah'}</div>
                </div>`;
            }
            $(parentElement).find('._benar_salah_right_answers').html(html);
            $(parentElement).find('._benar_salah_session').first().css('display', 'block');

            $(parentElement).find('._benar_salah_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._benar_salah_radio').each((index, element) => {
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

    // Check if the current question type is memasangkan
    if ($(parentElement).data('type') === 'memasangkan') {
        var answers = Array();
        let type = $(parentElement).data('type');

        var qKeys = Array();
        var aKeys = Array();

        $(parentElement).find('._memasangkan_jawaban_key').each((index, element) => {
            qKeys.push($(element).data('key'));
        });

        var nulVal = 0;

        $(parentElement).find('._memasangkan_jawaban_key').each((index, element) => {
            aKeys.push($(element).val().toUpperCase());

            if ($(element).val() === '') {
                nulVal++;
            }
        });

        var temp = {};
        for (let i = 0; i < qKeys.length; i++) {
            temp[qKeys[i]] = aKeys[i];
        }
        answers.push(temp);

        answers = answers[0];

        let data = {
            'id' : $(parentElement).data('id'),
            'task_id' : $('.question-list').data('task'),
            'answer' : answers,
            'repeatance' : $(parentElement).data('repeat'),
            'type': type
        }

        // Send ajax request
        AjaxRequest(data, (res) => {

            var list = '';

            $(parentElement).find('._memasangkan_pertanyaan div:nth-child(2)').each((index, element) => {
                list += `
                    <tr>
                        <td>${$(element).html()}</td>
                        <td><i class="kejar-arrow-right"></i></td>
                        <td>Lorem ipsum dolor sit amet.</td>
                    </tr>
                `;
            });


            var html = `
                <div class="_memasangkan_jawaban_benar">
                    <table>
                        ${list}
                    </table>
                </div>
            `;
        
            $(parentElement).find('._memasangkan_right_answers').append(html);

            $(parentElement).find('._memasangkan_session').first().css('display', 'block');

            $(parentElement).find('._memasangkan_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._memasangkan_answer input').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

        // Check if the current question type is melengkapi_tabel
    if ($(parentElement).data('type') === 'melengkapi_tabel') {
        var arrayAnswers = Array();
        let type = $(parentElement).data('type');

        $(parentElement).find('table tbody tr').each((index, tr) => {
            var row = [];
            $(tr).find('td').each((ind, td) => {
                if ($(td).find('input').length > 0) {
                    row.push({ "type": "answer", "value": $(td).find('input').val().toLowerCase() });
                } else {
                    row.push({ "type": "question", "value": $(td).html() });
                }
            });
            arrayAnswers.push(row);
            row = [];
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

            var header = $(parentElement).find('._melengkapi_tabel_tabel thead tr').html();
            var body = ``;
            res.answer.forEach(dat => {
                body += `<tr>`;
                dat.forEach(td => {
                    if (td.type === 'question') {
                        body += `<td class="_melengkapi_tabel_td_question">
                                    ${ td.value }
                                </td>`;
                    } else {
                        body += `<td class="_melengkapi_tabel_td_answer">
                                    ${ td.value }
                                </td>`;
                    }
                });
                body += `</tr>`;
            });
            var html = `
                <div class="table-responsive-md">
                    <table class="_melengkapi_tabel_table_session">
                        <thead>
                            ${ header }
                        </thead>
                        <tbody>
                            ${ body }
                        </tbody>
                    </table>
                </div>
            `;
        
            $(parentElement).find('._melengkapi_tabel_right_answers').append(html);

            $(parentElement).find('._melengkapi_tabel_session').first().css('display', 'block');

            $(parentElement).find('._melengkapi_tabel_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._melengkapi_tabel_input').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    // Check if the current question type is merinci
    if ($(parentElement).data('type') === 'merinci') {
        var arrayAnswers = Array();
        let type = $(parentElement).data('type');

        $(parentElement).find('._merinci_input').each((index, data) => {
            arrayAnswers.push($(data).val());
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
                body += `<li>${dat}</li>`;
            });

            var html = `
                <ul>
                    ${body}
                </ul>
            `;
        
            $(parentElement).find('._merinci_right_answers').append(html);

            $(parentElement).find('._merinci_session').first().css('display', 'block');

            $(parentElement).find('._merinci_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._merinci_input').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    // Check if the current question type is esai
    if ($(parentElement).data('type') === 'esai') {
        var answer = $(parentElement).find('.ck-content').html();
        var type = $(parentElement).data('type');

        let data = {
            'id' : $(parentElement).data('id'),
            'task_id' : $('.question-list').data('task'),
            'answer' : answer,
            'repeatance' : $(parentElement).data('repeat'),
            'type': type
        }

        
        // Send ajax request
        AjaxRequest(data, (res) => {

            $(parentElement).find('._esai_session').first().css('display', 'block');

            $(parentElement).find('._esai_explanation div').html(`${res.explanation}`);

            $(parentElement).find('.ck-content').css({'pointer-event': 'disabled'});

            if (answer === '<p data-placeholder="Ketik jawaban di sini..." class="ck-placeholder"><br data-cke-filler="true"></p>') {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    // Check if the current question type is isian_bahasan
    if ($(parentElement).data('type') === 'isian_bahasa') {
        var answer = $(parentElement).find('._isian_bahasa_textarea').text();
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
            var body = ``;
            for (let index = 0; index < res.answer.length; index++) {
                body += `<tr><td><i class="kejar-soal-benar"></i></td>
                        <td>${ res.answer[index] }</td></tr>`;
            }

            var html = `
                <table>
                    ${ body }
                </table>
            `;
        
            $(parentElement).find('._isian_bahasa_right_answers').append(html);

            $(parentElement).find('._isian_bahasa_session').first().css('display', 'block');

            $(parentElement).find('._isian_bahasa_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._isian_bahasa_input').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    // Check if the current question is Menceklis
    if ($(parentElement).data('type') === 'menceklis') {
        var answers = Array();
        let type = $(parentElement).data('type');

        $(parentElement).find('input:checked').each((index, element) => {
            answers.push($(element).val());
        });

        let data = {
            'id' : $(parentElement).data('id'),
            'task_id' : $('.question-list').data('task'),
            'answer' : answers,
            'repeatance' : $(parentElement).data('repeat'),
            'type': type
        }

        // Send ajax request
        AjaxRequest(data, (res) => {
            var body = ``;
            for (let index = 0; index < res.answer.length; index++) {
                body += `
                    <li class="d-flex align-items-start mb-1">
                        <div>
                            <i class="kejar-checked-box mr-2"></i>
                        </div>
                        <div>
                            ${res.answer[index]}
                        </div>
                    </li>
                `;
            }

            var html = `
                <ul class="list-unstyled">
                    ${ body }
                </ul>
            `;
        
            $(parentElement).find('._menceklis_right_answers').append(html);

            $(parentElement).find('._menceklis_session').first().css('display', 'block');

            $(parentElement).find('._menceklis_explanation div').html(`${res.explanation}`);

            $(parentElement).find('._menceklis_input').each((index, element) => {
                $(element).prop('disabled', true);
            });

            if (res.status === false) {
                wrongAnswer();
            }

            buttonFunction(parentElement);

        });
    }

    // Check if the current question is Teks Rumpang
    if ($(parentElement).data('type') === 'rumpang') {
        var answers = Array();
        let type = $(parentElement).data('type');

        $(parentElement).find('input[name="answer"]').each((index, element) => {
            answers.push($(element).val());
        });

        let data = {
            'id' : $(parentElement).data('id'),
            'task_id' : $('.question-list').data('task'),
            'answer' : answers,
            'repeatance' : $(parentElement).data('repeat'),
            'type': type
        }

        // Send ajax request
        AjaxRequest(data, (res) => {
            var body = ``;
            res.answer.forEach((el) => {
                body += `${el}, `;
            });

            body = body.slice(0, -2);

            var html = `<p>${body}</p>`;
        
            $(parentElement).find('._rumpang_right_answers').append(html);

            $(parentElement).find('._rumpang_session').first().css('display', 'block');

            $(parentElement).find('._rumpang_explanation div').html(`${res.explanation}`);

            $(parentElement).find('.dropdown-toggle').each((index, element) => {
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
        $(parentElement).find('._question_button').addClass('_next_button').html('LANJUT <i class="kejar kejar-next"></i>').prop('disabled', false);
    } else {
        $(parentElement).find('._question_button').addClass('_soal_cerita_finish').html('SELESAI <i class="kejar kejar-next"></i>').prop('disabled', false);
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
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._benar_salah_session').css('display', 'none');
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
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
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
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
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
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
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'mengurutkan') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('input').each((index, element) => {
                $(element).val('').prop('disabled', false);
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._mengurutkan_session').css('display', 'none');
            $(cloned).find('._mengurutkan_session').find('._mengurutkan_answers').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'memasangkan') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('._memasangkan_answer input').each((index, element) => {
                $(element).prop('disabled', false).removeAttr('checked');
                $(element).val('');
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._memasangkan_session').css('display', 'none');
            $(cloned).find('._memasangkan_session').find('._memasangkan_right_answers div').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'melengkapi_tabel') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('._melengkapi_tabel_input').each((index, element) => {
                $(element).prop('disabled', false).val('');
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._melengkapi_tabel_session').css('display', 'none');
            $(cloned).find('._melengkapi_tabel_session').find('.table-responsive-md').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'merinci') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('._merinci_input').each((index, element) => {
                $(element).prop('disabled', false).val('');
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._merinci_session').css('display', 'none');
            $(cloned).find('._merinci_session').find('ul').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'esai') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('._esai_input').each((index, element) => {
                $(element).prop('disabled', false).val('');
            });
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._esai_session').css('display', 'none');
            $(cloned).find('._esai_session').find('ul').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'isian_bahasa') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('._isian_bahasa_textarea').html('');
            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._isian_bahasa_session').css('display', 'none');
            $(cloned).find('._isian_bahasa_session ._isian_bahasa_right_answers table').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'menceklis') {
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('input:checked').each((index, element) => {
                $(element).next('i').attr('class', 'kejar kejar-check-box');
                $(element).prop('checked', false);
            });

            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._menceklis_session').css('display', 'none');
            $(cloned).find('._menceklis_session ._menceklis_right_answers ul').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
            $(cloned).find('._question_button').html('CEK JAWABAN <i class="kejar kejar-next"></i>');
    
            $('.question-list').append(cloned);
        }
    }

    if ($(currentQuestion).data('type') === 'rumpang') {
        console.log('wrong');
        if ($(currentQuestion).data('repeatance') < 2) {
            var cloned = $(currentQuestion).clone(false);

            $(cloned).find('.dropdown').each((index, element) => {
                $(element).find('.dropdown-toggle').prop('disabled', false);
                $(element).find('input').val('');
                $(element).find('button').html('<div class="d-flex justify-content-between align-items-center"><span>...</span><i class="kejar kejar-dropdown"></i></div>');
            });

            $(cloned).css('display', 'none');
            $(cloned).attr('data-repeat', 'true');
            $(cloned).find('._rumpang_session').css('display', 'none');
            $(cloned).find('._rumpang_session ._rumpang_right_answers p').remove();
            $(cloned).find('._question_button').removeClass('_next_button');
            $(cloned).find('._question_button').addClass('_check_button');
            $(cloned).find('._question_button').prop('disabled', true);
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
        $(parentElement).find('._question_button').prop('disabled', false);
    } else {
        $(parentElement).find('._question_button').prop('disabled', true);
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
$(document).on('input', '._mengurutkan_answer input', function(){
    var currentElement = $('.question-group:visible');

    var inEl = 0;
    $(currentElement).find('input').each(function(){
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

});
// End Mengurutkan

// Pilihan Ganda

$(document).on('input', 'input[type=text]', function(){
    var currentElement = $('.question-group:visible');

    var numInput = 0;
    $(currentElement).find('input[type=text]').each(function(){
        if ($(this).val() != '') {
            numInput++;
        } else {
            numInput--;
        }
    });

    if (numInput == $(currentElement).find('input[type=text').length) {
        $(currentElement).find('._question_button').prop('disabled', false);
    } else {
        $(currentElement).find('._question_button').prop('disabled', true);
    }
});

// End Pilihan Ganda

// Melengkapi Tabel
$(document).on('input', '._melengkapi_tabel_input', (e) => {
    var currentQuestion = $('.question-group:visible');
    var count = 0;
    $(currentQuestion).find("._melengkapi_tabel_input").each((index, element) => {
        if (element.value === "") {
            count++;
        }
    });

    if( count === 0 ) {
        $(currentQuestion).find('._question_button').prop('disabled', false).removeClass('disabled');
    } else {
        $(currentQuestion).find('._question_button').prop('disabled', true).addClass('disabled');
    }
});
// End Melengkapi Tabel

// Merinci
$(document).on('input', '._merinci_input', (e) => {
    var currentQuestion = $('.question-group:visible');
    var count = 0;

    $(currentQuestion).find("._merinci_input").each((index, element) => {
        if (element.value === "") {
            count++;
        }
    });

    if( count === 0 ) {
        $(currentQuestion).find('._question_button').prop('disabled', false);
    } else {
        $(currentQuestion).find('._question_button').prop('disabled', true);
    }
});
// End Merinci

// Esai
$(document).on('input keyup', '.ck-content', function(){

    var currentElement = $('.question-group:visible');

    if ($(this).text() != '') {
        $(currentElement).find('._question_button').prop('disabled', false);
    } else {
        $(currentElement).find('._question_button').prop('disabled', true);
    }
});

$('.esai_answer').find('textarea').each((index, element) => {
    initalizeEditor(index, element);
});


$(document).on('click', '.ckeditor-btn-1 .bold-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(0)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .italic-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(1)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .underline-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(2)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .bullet-list-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(3)').click();
    checkActive();
});

$(document).on('click', '.ckeditor-btn-1 .number-list-btn', function(){
    $(this).parent().prev().find('.ck-toolbar__items button:eq(4)').click();
    checkActive();
});

$(document).on('click', '.ck-content p, .ck-content ul li, .ck-content ol li', function(){
    checkActive();
});

$(document).keydown(function(e){
    checkActive();
});

function checkActive(){
    $('.ckeditor-btn-1').each(function(){
        var ckeditorBtnGroup = $(this);
        var ckeditorDiv = ckeditorBtnGroup.prev();

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(0)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.bold-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.bold-btn').removeClass('active');
        }

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(1)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.italic-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.italic-btn').removeClass('active');
        }

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(2)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.underline-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.underline-btn').removeClass('active');
        }

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(3)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.bullet-list-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.bullet-list-btn').removeClass('active');
        }

        if (ckeditorDiv.find('.ck-toolbar__items button:eq(4)').hasClass('ck-on')) {
            ckeditorBtnGroup.find('.number-list-btn').addClass('active');
        } else {
            ckeditorBtnGroup.find('.number-list-btn').removeClass('active');
        }

    });
}

$(document).on('mousedown', '.ckeditor-list .bold-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .italic-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .underline-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .bullet-list-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .number-list-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('mousedown', '.ckeditor-list .photo-btn', function(){
    thisEl = $(this);
    setTimeout(function () { thisEl.parent().prev().find('.ck-content').focus(); }, 0);
});

$(document).on('input', '.answer-list-table-pg input[type=radio]', function() {
    radioPgManagement();
});

$(document).on('focus', '.ckeditor-list .ck-content', function(){
    $(this).parents().closest('.ck-editor').next().removeClass('d-none');
}).on('blur', '.ckeditor-list .ck-content', function(){
    $(this).parents().closest('.ck-editor').next().addClass('d-none');
});

function initalizeEditor(index, element) {
    ClassicEditor
    .create( element, {
        toolbar: {
            items: [
                'bold',
                'italic',
                'underline',
                'bulletedList',
                'numberedList',
            ]
        },
        language: 'en',
        image: {
            styles: [
                'alignLeft', 'alignCenter', 'alignRight'
            ],
            resizeOptions: [
                {
                    name: 'imageResize:original',
                    label: 'Original',
                    value: null
                },
                {
                    name: 'imageResize:50',
                    label: '50%',
                    value: '50'
                },
                {
                    name: 'imageResize:75',
                    label: '75%',
                    value: '75'
                }
            ],
            toolbar: [
                'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                '|',
                'imageResize',
            ],
        },
        licenseKey: '',
    } )
    .then( editor => {
        
    } )
    .catch( error => {
        console.error( 'Oops, something went wrong!' );
        console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
        console.warn( 'Build id: nekgv7mmfgzn-cehsg6b07p1b' );
        console.error( error );
    } );
    
}
// End Esai
// Isian Bahasa
$(document).on('input', '._isian_bahasa_textarea', (e) => {
    var currentQuestion = $('.question-group:visible');
    
    if( $(e.target)[0].innerText !== "" ) {
        $('._question_button').prop('disabled', false);
    } else {
        $('._question_button').prop('disabled', true);
    }
});
// End Isian Bahasa

// Menceklis Dari Daftar
$(document).on('click', '.md-checkbox-answer input', function(){

    currentQuestion = $('.question-group:visible');
    var iconEl = $(this).next();
    if ($(this).is(':checked')) {
        iconEl.attr('class', 'kejar kejar-checked-box');
    } else {
        iconEl.attr('class', 'kejar kejar-check-box');
    }
    
    if ($(currentQuestion).find('input:checked').length != 0) {
        $(currentQuestion).find('._question_button').prop('disabled', false);
    } else {
        $(currentQuestion).find('._question_button').prop('disabled', true);
    }
});
// End Menceklis Dari Daftar


// Teks Rumpang PG

$(document).on('click', '.dropdown-item', function(){
    var currentElement = $('.question-group:visible');
    var type = $(this).data('type');
    var value = $(this).data('value');
    if (type == 'answer') {
        $(this).parent().prev().find('span').text($(this).text());
        $(this).parents('.dropdown').find('input').val(value);
    }

    var totalAnswer = 0;
    $(currentElement).find('.answer-field').each(function(){
        totalAnswer += $(this).val() != '' ? 1 : 0;
    });

    if (totalAnswer == $(currentElement).find('.answer-field').length) {
        $(currentElement).find('._question_button').prop('disabled', false);
    } else {
        $(currentElement).find('._question_button').prop('disabled', true);
    }
});

$(document).ready(function(){
    var currentElement = $('.question-group:visible');

    $(currentElement).find('.rmpg-question-answer p').each(function(){
        var content = '<div class="question-group">' + $(this).html() + '</div>';
        $(content).insertAfter($(this));
        $(this).remove();
    });
});

// End Teks Rumpang PG

// Benar Salah
$(document).on('click', '._benar_salah_option label', (e) => {
    var currentElement = $('.question-group:visible');

    $(e.currentTarget).prev('input').prop('checked', true);

    var radios = $(currentElement).find('._benar_salah_radio').length;
    var radiosQuestions = radios / 2;

    if ($(currentElement).find('._benar_salah_radio:checked').length >= radiosQuestions) {
        $(currentElement).find('._check_button').prop('disabled', false);
    } else {
        $(currentElement).find('._check_button').prop('disabled', true);
    }
});
// End Benar Salah

// Ya Tidak
$(document).on('click', '._ya_tidak_options label', (e) => {
    var currentElement = $('.question-group:visible');

    $(e.currentTarget).prev('input').prop('checked', true);

    var radios = $(currentElement).find('._ya_tidak_radio').length;
    var radiosQuestions = radios / 2;

    if ($(currentElement).find('._ya_tidak_radio:checked').length >= radiosQuestions) {
        $(currentElement).find('._check_button').prop('disabled', false);
    } else {
        $(currentElement).find('._check_button').prop('disabled', true);
    }
});
// End Ya Tidak