@extends('layout.exam')

@section('title', 'Student Exam')

@section('content')
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
                <a href="#exitExamModal" data-toggle="modal">
                    <i class="kejar kejar-exit"></i> Keluar
                </a>
            </div>
        </nav>
        <!-- Command Text -->
        <div class="command">
            <p class="command-text">Jawablah dengan benar!</p>
        </div>
        <form class="question-list" id="question-list" method="POST" action="{{ url('students/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/' . $taskId . '/finishes') }}" id="process" data-total="{{ count($questions) }}" data-task="{{ $taskId }}" data-check="{{ secure_url('students/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/check') }}" data-timer="{{ $timespan }}">
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
@endsection