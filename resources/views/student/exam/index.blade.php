<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>Siswa | Exam</title>
        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
        <link href="{{ url('/assets/css/layout.css') }}" rel="stylesheet">
        <link href="{{ url('/assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ url('/assets/css/matrikulasi_exam/style.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-12 p-0 timer-stick-container">
                    <!-- Timer Stick -->
                    <div class="timer-stick">
                        <div class="timer-length"></div>
                    </div>
                </div>
                <div class="col-md-10 col-sm-12">
                    <!-- Exam Navbar -->
                    <nav class="d-flex justify-content-between exam-navbar">
                        <div class="question-amount">
                            <span class="active number">1</span> / {{ count($questions) ?? 0 }}
                        </div>
                        <div class="link-logout">
                            <a href="#exitExamModal" data-toggle="modal" >
                                <i class="kejar kejar-exit"></i> Keluar
                            </a>
                        </div>
                    </nav>
                    <!-- Command Text -->
                    <div class="command">
                        <p class="command-text">Jawablah dengan benar!</p>
                    </div>
                    <form class="question-list" id="question-list" method="POST" action="{{ url('student/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/' . $taskId . '/finish') }}" id="process" data-total="{{ count($questions) }}" data-task="{{ $taskId }}" data-check="{{ url('student/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/check') }}" data-timer="{{ $timespan }}">
                        @foreach($questions as $key => $question)
                        <div class="question-item" data-index="{{ $key }}" data-number="{{ ++$key }}" data-repeatance="0" data-id="{{ $question['id'] }}">
                            <!-- Notification -->
                            <div class="notification">
                                <p class="notification-text notification-success">
                                    <i class="kejar kejar-soal-benar"></i> Benar!
                                </p>
                                @if($game == 'OBR')
                                <p class="notification-text notification-failed">
                                    &times; Salah
                                </p>
                                @else
                                <p class="notification-text notification-failed">
                                    &times; Seharusnya: <span class="text-dark d-inline seharusnya"></span>
                                </p>
                                @endif
                            </div>
                            <!-- Question -->
                            <div class="question">
                                <h1 class="question-text">{{ $question['question'] }}</h1>
                            </div>
                            <!-- Answer Input -->
                            <div class="answer">
                                <input type="text" class="answer-input" name="answer[{{ $key }}]" data-status="false" autocomplete="off">
                            </div>
                            <!-- Next Button -->
                            <div class="next-button">
                                <button class="btn btn-next btn-next-disabled" disabled>Lanjut <i class="kejar kejar-next"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </body>
    <!-- Modal -->
    <div class="modal fade" id="selesai" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        SELESAI
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ulangi</button>
                    <button type="button" class="btn btn-primary">Ronde Berikutnya</button>
                </div>
            </div>
        </div>
    </div>
    @include('student.modals._exit_exam')
    <script src="{{ url('assets/js/jquery.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.js') }}"></script>
    <script src="{{ url('assets/js/student/exam/script.js') }}"></script>
</html>
