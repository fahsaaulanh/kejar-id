@extends('layout.index')

@section('title', 'Exam')

@section('content')
<div class="container">
    <!-- Title -->
    <div>
        <h4 id="title1" class="text-reguler mb-2"></h4>
        <h2 id="title2"></h2>
    </div>

    <!--  -->
    <div class="mt-2">
        <h5 class="text-reguler">Waktu Tersisa: <span id="timer"></span></h5>
    </div>

    <!-- Content -->
    <div class="row mt-8">
        <div class="col-md-6 mb-md-0 mb-2">
            <h5>{{ $userable['name'] }}</h5>
            <h5 class="text-reguler">NIS {{ $userable['nis'] }} | {{ $userable['student_group']['name'] }}</h5>
        </div>
    </div>

    <div class="px-4 mt-8 row">
        <div id="lihat-naskah" class="pts-btn-pdf" role="button">
            <i class="kejar-pdf"></i>
            <h4 class="text-reguler ml-4">Lihat Naskah Soal</h4>
        </div>
    </div>

    <!-- PG -->
    <div class="mt-8">
        <h5 class="my-2">Lembar Jawaban</h5>
        <div class="pt-2 pb-2 pl-4 pr-4 bg-blue-tp-2">
            <p class="mt-2 text-grey-3">Klik jawaban yang benar. Pastikan loading penyimpanan selesai sampai muncul icon ceklis di samping jawaban.</p>
            <p class="mt-2 text-grey-3">Jika loading terus-menerus, refresh halaman ini dan klik ulang jawaban yang dipilih.</p>
        </div>
    </div>

    @php
    $collected = collect($task['assessment']['questions']);
    $divider = (float) ($collected->count() / 2);
    $divider = ceil($divider);
    @endphp

    <div class="row">
        <div class="col-md-6">
            @foreach ($collected as $t)
            @if (($loop->index + 1) <= $divider) <div class="row px-4 mt-4">
                <div class="pts-number text-grey-3">{{ $loop->index + 1 }}</div>
                @php
                $answerId = $t['id'];
                $choices = $t['choices'];
                @endphp
                <div class="col">
                    <div class="row align-items-center">
                        @foreach ($choices as $c)
                        <div class="choice-group-{{$answerId}} mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice {{ $answers[$answerId]['answer'] === $c ? 'active' : '' }}" data-id="{{ $answers[$answerId]['id'] }}" onclick="onClickAnswerPG('{{ $c }}', '{{ $loop->parent->index }}', '{{ json_encode($choices) }}', '{{ $answerId }}')" id="pts-choice-{{$loop->parent->index}}-{{$c}}">
                            <span class="caption-{{ $c.'-'.$answerId }}">{{ $c }}</span>
                        </div>
                        @endforeach
                        <div id="spinner-{{$answerId }}" class="spinner-border ml-5 text-grey-3" style="display:none">
                            <span class="sr-only"></span>
                        </div>
                        <div id="spinner-{{$answerId }}-done" class="save-answer ml-5" style="display:none">
                            <span class="sr-only"></span>
                            <i class="kejar-soal-benar"></i>
                        </div>
                    </div>
                </div>
        </div>
        @endif
        @endforeach
    </div>
    <div class="col-md-6">
        @foreach ($collected as $t)
        @if (($loop->index + 1) > $divider)
        <div class="row px-4 mt-4">
            <div class="pts-number text-grey-3">{{ $loop->index + 1 }}</div>
            @php
            $answerId = $t['id'];
            $choices = $t['choices'];
            @endphp
            <div class="col">
                <div class="row align-items-center">
                    @foreach ($choices as $c)
                    <div class="choice-group-{{$answerId}} mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice {{ $answers[$answerId]['answer'] === $c ? 'active' : '' }}" data-id="{{ $answers[$answerId]['id'] }}" onclick="onClickAnswerPG('{{ $c }}', '{{ $loop->parent->index }}', '{{ json_encode($choices) }}', '{{ $answerId }}')" id="pts-choice-{{$loop->parent->index}}-{{$c}}">
                        <span class="caption-{{ $c.'-'.$answerId }}">{{ $c }}</span>
                    </div>
                    @endforeach
                    <div id="spinner-{{$answerId }}" class="spinner-border ml-5 text-grey-3" style="display:none">
                        <span class="sr-only"></span>
                    </div>
                    <div id="spinner-{{$answerId }}-done" class="save-answer ml-5" style="display:none">
                        <span class="sr-only"></span>
                        <i class="kejar-soal-benar"></i>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>

<div class="row justify-content-between align-items-center px-4 mt-9">
    <div class="row align-items-center text-grey-3">
        Waktu tersisa
        <h5 id="timer-bottom" class="ml-2"></h5>
    </div>
    <div id="done" class="pts-btn-next bg-light text-purple" role="button">
        <h3>Selesai</h3>
        <i class="kejar-matrikulasi text-purple font-32">kejar-play</i>
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
    let promises = {};
    let hasTime = true;
    let doneDownloadAnswer = false;
    let doneCheckAnswer = false;
    let doneSuccess = false;
    startTimer();
    this.sendToServer = _.debounce(this.sendToServer, 1000);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.document.title = "Exam - " + localStorage.getItem('pts_title');

    $('#title2').html(localStorage.getItem('detail_title') || '');
    $('#title1').html(localStorage.getItem('pts_title') || '');
    $('#lihat-naskah').on('click', function() {
        if (typeof window !== undefined) {
            window.open("{{ $task['assessment']['pdf'] }}", '_blank');
        }
    });

    $('#done').on('click', function() {
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

    $('#downloadAnswerSheet').on('hide.bs.modal', function(e) {
        doneDownloadAnswer = false;
    })

    $('#checkAnswerSheet').on('hide.bs.modal', function(e) {
        doneCheckAnswer = false;
    })

    function getMobileOperatingSystem() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        // Windows Phone must come first because its UA also contains "Android"
        if (/windows phone/i.test(userAgent)) {
            return "Windows Phone";
        }

        if (/android/i.test(userAgent)) {
            return "Android";
        }

        // iOS detection from: http://stackoverflow.com/a/9039885/177710
        if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            return "iOS";
        }

        return "unknown";
    }

    $('#download-answer').on('click', function(e) {
        // Function Agung in Here
        e.preventDefault();
        const defaultCaption = $('#download-answer').html();
        $('#download-answer').html('Tunggu...');
        $('#download-answer').attr('disabled', true);
        $('#skip-download').attr('disabled', true);
        $('#downloadAnswerSheet .close').attr('disabled', true);

        //set delay to let session store first, note : delay only estimate
        setTimeout(function() {
            const urlPrint = "{!! URL::to('/student/assessment/exam/pdf') !!}";
            var a = document.createElement("a");
            a.href = urlPrint;
            document.body.appendChild(a);
            a.click();

            setTimeout(function() {
                $('#download-answer').html(defaultCaption);
                $('#download-answer').removeAttr('disabled');
                $('#skip-download').removeAttr('disabled');
                $('#downloadAnswerSheet .close').removeAttr('disabled');
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
        const noteStudent = $.trim($("#noteStudent").val());
        setDataToStorage('enc_n', noteStudent);
        submitTask($(this));
    });

    $('#lanjut-time-up').on('click', function() {
        finish($(this));
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

    function viewSpinner(answer, questionId, set) {
        if (set === 'value') {
            if (Array.isArray(answer)) {
                $(".caption-" + questionId).show();
                $(".spinner-" + questionId).hide();
            } else {
                $(".caption-" + answer + '-' + questionId).show();
                $("#spinner-" + questionId).hide();
                $("#spinner-" + questionId + '-' + 'done').show()
                setInterval(function() {
                    $("#spinner-" + questionId + '-' + 'done').hide()
                }, 2000);
            }
            $(".choice-group-" + questionId).css("pointer-events", "auto");
        } else if (set === 'spinner') {
            $(".choice-group-" + questionId).css("pointer-events", "none");
            $(".caption-" + answer + '-' + questionId).show();
            $("#spinner-" + questionId).show();
        }
    }

    function onClickAnswerPG(choice, parentIndex, choicesEncoded, questionId) {
        const selected = $(`#pts-choice-${parentIndex}-${choice}`).hasClass('active');
        const answer = choice;
        const answerId = $(`#pts-choice-${parentIndex}-${choice}`).attr('data-id')

        viewSpinner(answer, questionId, 'spinner');
        const choices = JSON.parse(choicesEncoded);
        choices.forEach((choice) => {
            $(`#pts-choice-${parentIndex}-${choice}`).removeClass('active');
        })

        $(`#pts-choice-${parentIndex}-${choice}`).addClass('active');
        promises[parentIndex] = setAnswer(answerId, answer, questionId);

        sendToServer();
    }

    function onClickAnswerCheck(index, parentIndex, choicesNumber, questionId) {
        const selected = $(`#pts-choice-${parentIndex}-${index}`).attr('data-active') === 'true';
        let arrayAnswer = [];
        arrayAnswer = $(`#pts-number-${parentIndex}`).attr('data-checked');
        if (arrayAnswer != 'null') {
            arrayAnswer = JSON.parse(arrayAnswer);
        } else {
            arrayAnswer = [];
        }

        const parsedIndex = parseInt(index, 10);
        const answer = String.fromCharCode(65 + parsedIndex);
        viewSpinner(answer, questionId, 'spinner');

        const answerId = $(`#pts-choice-${parentIndex}-${index}`).attr('data-id')

        if (!selected) {
            arrayAnswer = [...arrayAnswer, answer];
            $(`#pts-icon-${parentIndex}-${index}`).removeClass('kejar-check-box');
            $(`#pts-icon-${parentIndex}-${index}`).addClass('kejar-checked-box');
            $(`#pts-choice-${parentIndex}-${index}`).attr('data-active', true);
            $(`#pts-number-${parentIndex}`).attr('data-checked', JSON.stringify(arrayAnswer));
        } else {
            const idx = arrayAnswer.indexOf(answer);
            arrayAnswer.splice(idx, 1);
            $(`#pts-icon-${parentIndex}-${index}`).removeClass('kejar-checked-box');
            $(`#pts-icon-${parentIndex}-${index}`).addClass('kejar-check-box');
            $(`#pts-choice-${parentIndex}-${index}`).attr('data-active', false);
            $(`#pts-number-${parentIndex}`).attr('data-checked', JSON.stringify(arrayAnswer));
        }

        // promises = [...promises, setAnswer(answerId, arrayAnswer)];
        promises[parentIndex] = setAnswer(answerId, arrayAnswer, questionId);
        sendToServer();
    }

    function setAnswer(answerId, answer, questionId) {
        const url = "{!! URL::to('/student/assessment/service/answer') !!}";

        return $.ajax({
            url,
            type: 'POST',
            data: {
                ma_answer_id: questionId,
                answer_id: answerId,
                answer,
            },
            dataType: 'json',
            crossDomain: true,
            beforeSend: function() {
                //
            },
            error: function(error) {
                //
            },
            success: function(response) {
                if (response.status === 200) {
                    viewSpinner(answer, questionId, 'value');
                    return;
                }
            }
        });
    }

    async function sendToServer() {
        const keys = Object.keys(promises);
        const newPromises = keys.map((key) => promises[keys]);

        const responses = await Promise.all(newPromises);
        promises = {};
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

                localStorage.removeItem('enc_n');
            }
        });
    }

    function setDataToStorage(key, data) {
        if (typeof window !== 'undefined') {
            const encodedData = JSON.stringify(data);
            const encryptedText = window.aes.encrypt(encodedData, 'mini_assessment').toString();
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
            const decryptedText = window.aes.decrypt(encryptedText, 'mini_assessment').toString(encUtf8);
            const decodedData = JSON.parse(decryptedText);

            return decodedData;
        }
    }
</script>
@endpush
