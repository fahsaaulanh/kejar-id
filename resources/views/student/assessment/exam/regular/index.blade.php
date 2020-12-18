@extends('layout.index')

@section('title', 'Exam')

@section('header-exam')
@show

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/plugins/placeholder-loading/placeholder-loading.min.css') }}">
@endsection

@section('content')
<div class="container-exam">
    @php
        $questionLength = count($task['assessment']['questions']);
    @endphp

    @if($questionLength > 20)
    <div id="drawer" class="drawer-exam d-flex-column">
        <div class="row m-0">
            <h5>Daftar Soal</h5>
        </div>
        <div class="container-list-number">
            @foreach($task['assessment']['questions'] as $q)
            <div id="num-{{ $loop->index }}" class="list-number" role="button" onclick="setQuestion('{{ $loop->index }}')">
                {{ $loop->index + 1 }}
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div id="drawer" class="drawer-exam-row d-flex-column">
        <div class="row m-0 pl-5">
            <h5>Daftar Soal</h5>
        </div>
        <div class="container-list-number-row">
            @foreach($task['assessment']['questions'] as $q)
            <div id="num-{{ $loop->index }}" class="list-number-row" role="button" onclick="setQuestion('{{ $loop->index }}')">
                <div class="text-grey-3">
                    Soal {{ $loop->index + 1 }}
                </div>
                <div>
                    <i class="kejar-sudah-dikerjakan-outline text-grey-3"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="content-exam">
        <div>
            <div class="assesment-btn-question" role="button" onclick="toggleDrawer()">
                <i class="kejar-right"></i>
                <h5>Lihat Daftar Soal</h5>
            </div>
        </div>
        <div>
            <h4>SOAL <span id="current">1</span> <span class="text-grey-6">/ {{ count($task['assessment']['questions']) }}</span></h4>
        </div>
        <div id="question" class="assessment-question pt-2">
            <!-- Let it Empty -->
        </div>

        <div id="choices" class="row m-0 d-flex flex-column">
            <!-- Let it Empty -->
        </div>

        <div class="row m-0 content-footer">
            <div class="row px-4 mt-9">
                <button id="prev" class="assesment-btn-before mr-4" onclick="prevQuestion()">
                    <i class="kejar-arrow-left"></i>
                    <h5 class="text-reguler pl-2">Sebelumnya</h5>
                </button>
                <button id="next" class="assesment-btn-next" onclick="nextQuestion()">
                    <h5 class="text-reguler pr-2">Selanjutnya</h5>
                    <i class="kejar-arrow-right"></i>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection

@include('student.assessment.exam._time_up')
@include('student.assessment.exam._time_running_out')
@include('student.assessment.exam._time_remaining')
@include('student.assessment.exam._success')
@include('student.assessment.exam._missing_answer')
@include('student.assessment.exam._download_answer_sheet')
@include('student.assessment.exam._check_answer_sheet')
@include('student.assessment.exam._student_note')

@push('script')
<script>
    const defaultNext = `
        <h5 class="text-reguler pr-2">Selanjutnya</h5>
        <i class="kejar-arrow-right"></i>
    `;

    let promises = {};
    let hasTime = true;
    let doneDownloadAnswer = false;
    let doneCheckAnswer = false;
    let doneSuccess = false;
    let questions = getDataFromStorage('enc_q');
    let answers = getDataFromStorage('enc_a');

    this.sendToServer = _.debounce(this.sendToServer, 1500);

    if (question === null || answers === null) {
        getQuestions();
    } else {
        initNumber();
    }

    startTimer();

    $('#assessment-done').on('click', function() {
        checkAnswer();
    });

    $('#lanjut-missing-answer').on('click', function() {
        $('#missingAnswer').modal('hide');
        $('#timeRemaining').modal('show');
    });

    $('#skip-download').on('click', function() {
        $('#downloadAnswerSheet').modal('hide');
        $('#checkAnswerSheet').modal('show');
        // $('#studentNote').modal({
        //     backdrop: 'static',
        //     keyboard: false,
        //     show: true,
        // });
        doneCheckAnswer = true;
    });

    $('#lanjut-time-remaining').on('click', function() {
        finish($(this));
        doneDownloadAnswer = true;
    });

    $('#lanjut-time-up').on('click', function() {
        finish($(this));
    });

    $('#downloadAnswerSheet').on('hide.bs.modal', function(e) {
        doneDownloadAnswer = false;
    })

    $('#checkAnswerSheet').on('hide.bs.modal', function(e) {
        doneCheckAnswer = false;
    })

    $('#download-answer').on('click', function(e) {
        // Function Agung in Here
        e.preventDefault();
        $('#download-answer').html('Tunggu...');

        //set delay to let session store first, note : delay only estimate
        setTimeout(function() {
            const urlPrint = "{!! URL::to('/student/assessment/exam/pdf') !!}";
            var a = document.createElement("a");
            a.href = urlPrint;
            document.body.appendChild(a);
            a.click();

            setTimeout(function() {
                $('#downloadAnswerSheet').modal('hide');
                $('#checkAnswerSheet').modal('show');
            }, 2000)
        }, 3000)
    });

    $('#unduh-lagi-check-answer').on('click', function() {
        $('#checkAnswerSheet').modal('hide');
        $('#downloadAnswerSheet').modal('show');
    });

    $('#lanjut-check-answer').on('click', function() {
        $('#checkAnswerSheet').modal('hide');
        $('#studentNote').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    });

    $('#edit-note').on('click', function() {
        $('#success').modal('hide');
        $('#studentNote').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });
    });

    $('#simpan-note').on('click', function() {
        $('#studentNote').modal('hide');
        const noteStudent = $.trim($("#noteStudent").val());
        setDataToStorage('enc_n', noteStudent);
        submitTask($(this));
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function startTimer() {
        let modalRunningOutHasShown = false;

        var end = moment("{{ $task['assessment']['end_time'] }}");
        var endTime = end.valueOf();
        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get today's date and time and extend it
            var now = moment().valueOf();

            // Find the distance between now and the count down date
            var duration = endTime - now;

            // Time calculations for days, hours, minutes and seconds
            // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((duration % (1000 * 60)) / 1000);

            // Display the result in the element with id="timer"
            const hourString = `${hours < 10 ? '0' : ''}${hours}`;
            const minuteString = `${minutes < 10 ? '0' : ''}${minutes}`;
            const secondString = `${seconds < 10 ? '0' : ''}${seconds}`;
            const timerString = `${hourString}:${minuteString}:${secondString}`;
            $('#timer').html(timerString);
            $('#timer-bottom').html(timerString);

            // if duration only 5 more minutes
            if (duration < 300000 && !modalRunningOutHasShown && duration > 0) {
                modalRunningOutHasShown = true;
                $('#timeRunningOut').modal('show');
            }

            // If the count down is finished, finish the exam
            if (duration < 0) {
                hasTime = false;
                $('#timer').html('00:00:00');

                if (doneDownloadAnswer) {
                    $('#downloadAnswerSheet .kejar-close').remove();
                }

                if (doneCheckAnswer) {
                    $('#checkAnswerSheet .kejar-close').remove();
                }

                if (!doneDownloadAnswer && !doneCheckAnswer && !doneSuccess) {
                    $('#timeUp').modal('show');
                }

                $('#missingAnswer').modal('hide');
                $('#timeRunningOut').modal('hide');
                clearInterval(x);
            }
        }, 1000);
    }

    function initNumber() {
        if (typeof window !== 'undefined') {
            const current = localStorage.getItem('current');

            if (current !== null) {
                setQuestion(current);
                return;
            }

            localStorage.setItem('current', 0);
            setQuestion(0);
        }
    }

    function toggleDrawer() {
        var x = document.getElementById("drawer");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function myFunction() {
        var medScreen = window.matchMedia("(max-width: 1200px)")

        if (typeof window !== 'undefined') {
            if (medScreen.matches === true) { // If media query matches
                toggleDrawer();
            }
        }
    }

    function nextQuestion() {
        if (typeof window !== 'undefined') {
            const total = parseInt("{{ count($task['assessment']['questions']) }}", 10);
            const current = parseInt(localStorage.getItem('current'), 10) || 0;

            if (current >= total) {
                localStorage.setItem('current', total - 1);
                setQuestion(total - 1);
                return;
            }

            localStorage.setItem('current', current + 1);
            setQuestion(current + 1);
        }
    }

    function prevQuestion() {
        if (typeof window !== 'undefined') {
            const current = parseInt(localStorage.getItem('current'), 10) || 0;

            if (current < 0) {
                localStorage.setItem('current', 0);
                setQuestion(0);
                return;
            }

            localStorage.setItem('current', current - 1);
            setQuestion(current - 1);
        }
    }

    function getQuestions() {
        const url = "{!! URL::to('/student/assessment/service/questions') !!}";

        const retryButton = `
            <div>
                <p>Soal belum berhasil di dapatkan.</p>
                <button id="retry-button" class="btn btn-primary">Coba Lagi</button>
            </div>
        `;

        $.ajax({
            url,
            type: 'GET',
            data: {},
            dataType: 'json',
            crossDomain: true,
            beforeSend: function() {
                $('#question').html(loadingSkeleton());
                $('#choices').html('');
            },
            error: function(error) {
                $('#question').html(retryButton);
                $('#choices').html('');
                $('#retry-button').on('click', function() {
                    getQuestions();
                });
            },
            success: function(data) {
                questions = data.questions;
                answers = data.answers;
                setDataToStorage('enc_q', questions);
                setDataToStorage('enc_a', answers);
                initNumber();
            }
        });
    }

    function setQuestion(index) {
        const parsedIndex = parseInt(index, 10);
        const total = questions.length;
        const current = parseInt(localStorage.getItem('current'), 10) || null;

        const currentNum = parsedIndex + 1;
        $('#next').removeAttr('disabled');
        $('#next').removeClass('disabled');
        $('#prev').removeAttr('disabled');
        $('#prev').removeClass('disabled');

        if (currentNum >= total) {
            // $('#next').attr('disabled', true);
            $('#next').html('Selesai');
            $('#next').attr('onclick', "checkAnswer()");
            // $('#next').addClass('disabled');
        } else {
            $('#next').html(defaultNext);
            $('#next').attr('onclick', "nextQuestion()");
        }

        if (currentNum <= 1) {
            $('#prev').attr('disabled', true);
            $('#prev').addClass('disabled');
        }

        $('#current').html(currentNum);

        for (let i = 0; i <= total; i++) {
            $(`#num-${i}`).removeClass('active');
        }

        $(`#num-${index}`).addClass('active');

        const question = questions[parsedIndex];

        const choices = question.choices;
        const questionText = question.question;
        const keys = Object.keys(choices);
        const answerData = answers[question.id];
        let choicesView = '';

        keys.forEach((key, keyIndex) => {
            choicesView += `
                <div role="button" onclick="debounceAnswer('${key}', ${keyIndex}, ${index})" class="row m-0 align-items-center pt-6">
                    <div id="choice-${keyIndex}" data-id="${answerData.id}" class="choice-group-a mb-2 mb-md-0 mb-lg-0 mb-xl-0 ml-0 assessment-choice ${answerData.answer === key ? 'active' : ''}">
                        <span>${key}</span>
                    </div>
                    <div class="ml-4">
                        ${choices[key]}
                    </div>
                </div>
            `;
        });

        $('#question').html(questionText);
        $('#choices').html(choicesView);
    }

    async function sendToServer() {
        const keys = Object.keys(promises);
        const newPromises = keys.map((key) => promises[keys]);
        const responses = await Promise.all(newPromises);
        promises = {};
    }

    async function debounceAnswer(key, index, questionIndex) {
        for (let i = 0; i < 10; i++) {
            $(`#choice-${i}`).removeClass('active')
        }
        $(`#choice-${index}`).addClass('active')

        const question = questions[questionIndex];
        answers[question.id]['answer'] = key;
        setDataToStorage('enc_a', answers);

        promises[questionIndex] = await answer(key, index, questionIndex);
        sendToServer();
    }

    async function answer(key, index, questionIndex) {
        const url = "{!! URL::to('/student/assessment/service/answer') !!}";
        const answerId = $(`#choice-${index}`).attr('data-id');

        return $.ajax({
            url,
            type: 'POST',
            data: {
                answer_id: answerId,
                answer: key,
            },
            dataType: 'json',
            crossDomain: true,
        });
    }

    function finish(component) {
        const url = "{!! URL::to('/student/assessment/service/finish') !!}";

        const htmlSpinner = `Tunggu...`;

        const htmlSelesai = 'Kumpulkan Jawaban';

        component.html(htmlSelesai);
        component.removeAttr('disabled');

        $('#timeRemaining').modal('hide');
        $('#timeUp').modal('hide');
        $('#downloadAnswerSheet').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });

        doneSuccess = true;
        doneDownloadAnswer = true;
    }

    function checkAnswer() {
        const url = "{!! URL::to('/student/assessment/service/check') !!}";

        const htmlSpinner = `Tunggu...`;

        const htmlSelesai = $('#done').html();

        $.ajax({
            url,
            type: 'GET',
            data: {},
            dataType: 'json',
            crossDomain: true,
            beforeSend: function() {
                $('#done').html(htmlSpinner);
                $('#done').attr('disabled', 'true');
            },
            error: function(error) {
                $('#done').html(htmlSelesai);
                $('#done').removeAttr('disabled');
            },
            success: function(response) {
                $('#done').html(htmlSelesai);
                $('#done').removeAttr('disabled');
                if (response.error === false) {

                    if (response.unanswered === 0) {
                        $('#timeRemaining').modal('show');
                        return;
                    }

                    $('#missingAnswer').modal('show');
                }
            }
        });
    }

    async function submitTask(component) {
        const url = "{!! URL::to('/student/assessment/service/finish') !!}";

        const htmlSelesai = 'Simpan dan Selesai';

        const htmlSpinner = `Tunggu...`;

        $.ajax({
            url,
            type: 'POST',
            data: {},
            dataType: 'json',
            crossDomain: true,
            beforeSend: function() {
                component.html(htmlSpinner);
                component.attr('disabled', 'true');
            },
            error: function(error) {
                component.html(htmlSelesai);
                component.removeAttr('disabled');
            },
            success: function(response) {
                editNote(component);
                return;
            }
        });
    }

    async function editNote(component) {
        const url = "{!! URL::to('/student/assessment/service/edit_note') !!}";

        const htmlSpinner = `Tunggu...`;
        const htmlSelesai = 'Simpan dan Selesai';
        const noteStudent = getDataFromStorage('enc_n') || null;

        if (noteStudent !== null) {
            $('#note-student').html(noteStudent);
            $('#note-student').removeClass('text-gray');
        } else {
            $('#note-student').html('Tidak ada catatan.');
            $('#note-student').addClass('text-gray');
        }

        $.ajax({
            url,
            type: 'PATCH',
            data: {
                noteStudent
            },
            dataType: 'json',
            crossDomain: true,
            beforeSend: function() {
                component.html(htmlSpinner);
                component.attr('disabled', 'true');
            },
            error: function(error) {
                component.html(htmlSelesai);
                component.removeAttr('disabled');
            },
            success: function(response) {
                component.html(htmlSelesai);
                component.removeAttr('disabled');

                if (response.status === 200 && response.data.student_note !== null) {
                    $('#success').modal('show');
                    $('#studentNote').modal('hide');
                } else {
                    $('#success').modal('show');
                    $('#studentNote').modal('hide');
                }

                localStorage.removeItem('current');
                localStorage.removeItem('enc_q');
                localStorage.removeItem('enc_a');
                localStorage.removeItem('enc_n');
            }
        });
    }

    function loadingSkeleton() {
        return `
        <div class="ph-item border-0 px-0 pb-0 pt-2">
            <div class="ph-col-12 px-0 pb-0 pt-2">
                <div class="ph-row">
                    <div class="ph-col-4"></div>
                    <div class="ph-col-10"></div>
                    <div class="ph-col-10"></div>
                    <div class="ph-col-10"></div>
                    <div class="ph-col-10"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-4"></div>
                </div>
                <div class="ph-row">
                    <div class="ph-col-12 empty"></div>
                    <div class="ph-col-12 empty"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-12 empty"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-12 empty"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-12 empty"></div>
                    <div class="ph-col-4"></div>
                    <div class="ph-col-12 empty"></div>
                    <div class="ph-col-4"></div>
                </div>
            </div>
        </div>
        `;
    }

    function setDataToStorage(key, data) {
        if (typeof window !== 'undefined') {
            const encodedData = JSON.stringify(data);
            const encryptedText = window.aes.encrypt(encodedData, 'assessment').toString();
            localStorage.setItem(key, encryptedText);
        }
    }

    function getDataFromStorage(key) {
        if (typeof window !== 'undefined') {
            const encryptedText = localStorage.getItem(key) || null;

            if (!encryptedText) {
                return null;
            }

            const encUtf8 = window.enc;
            const decryptedText = window.aes.decrypt(encryptedText, 'assessment').toString(encUtf8);
            const decodedData = JSON.parse(decryptedText);

            return decodedData;
        }
    }

</script>
@endpush
