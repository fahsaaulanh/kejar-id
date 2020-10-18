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
        <h5 id="date" class="text-reguler">{{ $task['mini_assessment']['start_date'] }}</h5>
        <h5 id="time" class="text-reguler mt-2">{{ $task['mini_assessment']['start_time'] }} - {{ $task['mini_assessment']['expiry_time'] }}</h5>
    </div>

    <!-- Content -->
    <div class="row mt-8">
        <div class="col-md-6 mb-md-0 mb-2">
            <h5>{{ $userable['name'] }}</h5>
            <h5 class="text-reguler">NIS {{ $userable['nis'] }} | {{ $userable['class_name'] }}</h5>
        </div>

        <div class="col-md-6">
            <h5>Kode Paket</h5>
            <h5 class="text-reguler">
                {{ $task['mini_assessment']['random_char'] }}
            </h5>
        </div>
    </div>

    <div class="mt-8 row">
        <div id="lihat-naskah" class="pts-btn-pdf" role="button">
            <i class="kejar-matrikulasi">kejar-pdf</i>
            <h4 class="text-reguler ml-4">Lihat Naskah Soal</h4>
        </div>
    </div>

    <!-- PG -->
    <div class="mt-8">
        <h5>Pilihan Ganda</h5>
        <p class="mt-2">Pilihlah jawaban dengan benar!</p>
    </div>

    @php
        $collected = collect($task['answers']);
        $collectionPG = $collected->filter(function ($value, $key) {
            return !is_array($value['answer']);
        });
        $divider = (float) ($collectionPG->count() / 2);
        $divider = ceil($divider);
    @endphp

    <div class="row">
        <div class="col-md-6">
        @foreach ($task['answers'] as $t)
            @if (($loop->index + 1) <= $divider && !is_array($t['answer']))
            <div class="row px-4 mt-4">
                <div class="pts-number">{{ $loop->index + 1 }}</div>
                @php
                    $maAnswerId = $t['id'];
                    $choicesNumber = $task['answers'][$loop->index]['choices_number'];
                @endphp
                <div class="col">
                    <div class="row">
                        @for ($i = 0; $i < $choicesNumber; $i++)
                            <div class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice {{ $answers[$maAnswerId]['answer'] === chr(65 + $i) ? 'active' : '' }}" data-id="{{ $answers[$maAnswerId]['id'] }}" onclick="onClickAnswerPG('{{ $i }}', '{{ $loop->index }}', '{{ $choicesNumber }}', '{{ $maAnswerId }}')" id="pts-choice-{{$loop->index}}-{{$i}}">
                                {{ chr(65 + $i) }}
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
    <div class="col-md-6">
        @foreach ($task['answers'] as $t)
            @if (($loop->index + 1) > $divider && !is_array($t['answer']))
            <div class="row px-4 mt-4">
                <div class="pts-number">{{ $loop->index + 1 }}</div>
                @php
                    $maAnswerId = $t['id'];
                    $choicesNumber = $task['answers'][$loop->index]['choices_number'];
                @endphp
                <div class="col">
                    <div class="row">
                        @for ($i = 0; $i < $choicesNumber; $i++)
                            <div class="mb-2 mb-md-0 mb-lg-0 mb-xl-0 pts-choice {{ $answers[$maAnswerId]['answer'] === chr(65 + $i) ? 'active' : '' }}" data-id="{{ $answers[$maAnswerId]['id'] }}" onclick="onClickAnswerPG('{{ $i }}', '{{ $loop->index }}', '{{ $choicesNumber }}', '{{ $maAnswerId }}')" id="pts-choice-{{$loop->index}}-{{$i}}">
                                {{ chr(65 + $i) }}
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>

@php
    $collectionForCheck = $collected->filter(function ($value, $key) {
        return is_array($value['answer']);
    });
@endphp

<!-- Ceklis -->
@if ($collectionForCheck->count() > 0)
<div class="mt-8">
    <h5>Menceklis Daftar</h5>
    <p class="mt-2">Beri tanda centang di sebelah huruf sesuai jawaban yang dianggap benar!</p>
    @foreach ($task['answers'] as $t)
        @if (is_array($t['answer']))
        <div class="row px-4 mt-4">
            @php
                $maAnswerId = $t['id'];
                $choicesNumber = $task['answers'][$loop->index]['choices_number'];
            @endphp
            <div class="pts-number" id="pts-number-{{$loop->index}}" data-checked="{{ json_encode($answers[$maAnswerId]['answer']) }}">
                {{ $loop->index + 1 }}
            </div>
            <div class="col">
                <div class="row">
                    @for ($i = 0; $i < $choicesNumber; $i++)
                        <div
                            data-id="{{ $answers[$maAnswerId]['id'] }}"
                            data-active="{{ in_array(chr(65 + $i), $answers[$maAnswerId]['answer'] ?? []) ? 'true' : 'false' }}"
                            onclick="onClickAnswerCheck('{{ $i }}', '{{ $loop->index }}', '{{ $choicesNumber }}', '{{ $maAnswerId }}')"
                            id="pts-choice-{{$loop->index}}-{{$i}}"
                            class="mb-2 mb-md-2 mb-lg-2 mb-xl-2 pts-choice-check"
                        >
                            <i id="pts-icon-{{$loop->index}}-{{$i}}" class="font-24 mr-2">
                                {{ in_array(chr(65 + $i), $answers[$maAnswerId]['answer'] ?? []) ? 'kejar-checked-box' : 'kejar-check-box' }}
                            </i>
                            {{ chr(65 + $i) }}
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>
@endif

<div class="row justify-content-between align-items-center px-4 mt-9">
    <div>
        <h5 id="timer"></h5>
    </div>
    <div id="done" class="pts-btn-next bg-light text-purple" role="button">
        <h3>Selesai</h3>
        <i class="kejar-matrikulasi text-purple font-32">kejar-play</i>
    </div>
</div>
</div>
@endsection

@include('student.mini_assessment.exam._time_up')
@include('student.mini_assessment.exam._time_running_out')
@include('student.mini_assessment.exam._time_remaining')
@include('student.mini_assessment.exam._success')
@include('student.mini_assessment.exam._missing_answer')
@include('student.mini_assessment.exam._download_answer_sheet')
@include('student.mini_assessment.exam._check_answer_sheet')

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

    window.document.title = "Exam - "+localStorage.getItem('pts_title');

    $('#title2').html(localStorage.getItem('detail_title') || '');
    $('#title1').html(localStorage.getItem('pts_title') || '');
    $('#lihat-naskah').on('click', function() {
        if (typeof window !== undefined) {
            window.open("{{ $task['mini_assessment']['pdf'] }}", '_blank');
        }
    });

    $('#done').on('click', function() {
        checkAnswer();
    });

    $('#lanjut-missing-answer').on('click', function() {
        $('#missingAnswer').modal('hide');
        $('#timeRemaining').modal('show');
    });

    $('#lanjut-time-remaining').on('click', function() {
        $('#timeRemaining').modal('hide');
        $('#downloadAnswerSheet').modal('show');
        doneDownloadAnswer = true;
    });

    $('#downloadAnswerSheet').on('hide.bs.modal', function (e) {
        doneDownloadAnswer = false;
    })

    $('#checkAnswerSheet').on('hide.bs.modal', function (e) {
        doneCheckAnswer = false;
    })

    $('#download-answer').on('click', function() {
        // Function Agung in Here
        const urlPrint = "{!! URL::to('/student/mini_assessment/exam/pdf') !!}";

        $.ajax({
            url: urlPrint,
            type: 'GET',
            contentType: false,
            processData: false,
            //xhrFields is what did the trick to read the blob to pdf
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function() {
                $('#download-answer').html('Tunggu...');
            },
            error: function(error) {
                $('#download-answer').html('Silakan Unduh Ulang Lembar Jawaban');
            },
            success: function(response, status, xhr) {
                $('#download-answer').html('Unduh Lembar Jawaban');

                var filename = "";
                var disposition = xhr.getResponseHeader('Content-Disposition');

                if (disposition) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                }
                var linkelem = document.createElement('a');
                try {
                    var blob = new Blob([response], {
                        type: 'application/octet-stream'
                    });

                    if (typeof window.navigator.msSaveBlob !== 'undefined') {
                        //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                        window.navigator.msSaveBlob(blob, filename);
                    } else {
                        var URL = window.URL || window.webkitURL;
                        var downloadUrl = URL.createObjectURL(blob);

                        if (filename) {
                            // use HTML5 a[download] attribute to specify filename
                            var a = document.createElement("a");

                            // safari doesn't support this yet
                            if (typeof a.download === 'undefined') {
                                window.location = downloadUrl;
                            } else {
                                a.href = downloadUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.target = "_blank";
                                a.click();
                            }
                        } else {
                            window.location = downloadUrl;
                        }
                    }

                } catch (ex) {
                    console.log(ex);
                }

                $('#downloadAnswerSheet').modal('hide');
                if (!hasTime) {
                    $('#checkAnswerSheet .close').remove();
                    $('#checkAnswerSheet').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true,
                    });
                    $('#downloadAnswerSheet').modal('hide');
                    doneCheckAnswer = true;
                    return;
                }

                $('#checkAnswerSheet').modal('show');
                doneCheckAnswer = true;
            }
        });

        //
    });

    $('#unduh-lagi-check-answer').on('click', function() {
        $('#checkAnswerSheet').modal('hide');
        $('#downloadAnswerSheet').modal('show');
    });

    $('#selesai-check-answer').on('click', function() {
        finish($(this));
    });

    $('#lanjut-time-up').on('click', function() {
        $('#downloadAnswerSheet .close').remove();
        $('#downloadAnswerSheet').modal({
            backdrop: 'static',
            keyboard: false,
            show: true,
        });

        $('#timeUp').modal('hide');
    });

    $('#tutup-success').on('click', function() {
        if (typeof window !== 'undefined') {
            window.location.replace('/student/mini_assessment');
        }
    });

    function startTimer() {
        let modalRunningOutHasShown = false;

        var end = new Date("{{ $task['mini_assessment']['expiry_fulldate'] }}");
        // var end = new Date();
        // end.setMinutes(end.getMinutes() + 5);
        // end.setSeconds(end.getSeconds() + 17);
        const endTime = end.getTime();
        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get today's date and time
            var now = new Date().getTime();

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

    function onClickAnswerPG(index, parentIndex, choicesNumber, questionId) {
        const selected = $(`#pts-choice-${parentIndex}-${index}`).hasClass('active');
        const parsedIndex = parseInt(index, 10);
        const answer = String.fromCharCode(65 + parsedIndex);
        const answerId = $(`#pts-choice-${parentIndex}-${index}`).attr('data-id')

        for (let i = 0; i < choicesNumber; i++) {
            $(`#pts-choice-${parentIndex}-${i}`).removeClass('active');
        }

        $(`#pts-choice-${parentIndex}-${index}`).addClass('active');
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

        const answerId = $(`#pts-choice-${parentIndex}-${index}`).attr('data-id')

        if (!selected) {
            arrayAnswer = [...arrayAnswer, answer];
            $(`#pts-icon-${parentIndex}-${index}`).html('kejar-checked-box');
            $(`#pts-choice-${parentIndex}-${index}`).attr('data-active', true);
            $(`#pts-number-${parentIndex}`).attr('data-checked', JSON.stringify(arrayAnswer));
        } else {
            const idx = arrayAnswer.indexOf(answer);
            arrayAnswer.splice(idx, 1);
            $(`#pts-icon-${parentIndex}-${index}`).html('kejar-check-box');
            $(`#pts-choice-${parentIndex}-${index}`).attr('data-active', false);
            $(`#pts-number-${parentIndex}`).attr('data-checked', JSON.stringify(arrayAnswer));
        }

        // promises = [...promises, setAnswer(answerId, arrayAnswer)];
        promises[parentIndex] = setAnswer(answerId, arrayAnswer, questionId);
        sendToServer();
    }

    function setAnswer(answerId, answer, questionId) {
        const url = "{!! URL::to('/student/mini_assessment/service/answer') !!}";

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
        const url = "{!! URL::to('/student/mini_assessment/service/check') !!}";

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

    function finish(component) {
        const url = "{!! URL::to('/student/mini_assessment/service/finish') !!}";

        const htmlSpinner = `Tunggu...`;

        const htmlSelesai = 'Selesai';

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
                component.html(htmlSelesai);
                component.removeAttr('disabled');
                if (response.status === 200) {
                    $('#checkAnswerSheet').modal('hide');
                    $('#success').modal('show');
                    doneSuccess = true;
                    return;
                }
            }
        });
    }
</script>
@endpush
