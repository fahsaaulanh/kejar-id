@extends('layout.index')

@section('title', 'Exam : ' . $gameData['title'] . ' - ' . $round['title'])

@section('header')
@endsection

@section('content')
<div class="container-fluid exam">
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
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="link-logout">
                    <a href="#exitExamModal" data-toggle="modal">
                        <i class="kejar kejar-exit"></i> Keluar
                    </a>
                </div>
            </nav>
            <!-- Command Text -->
            <div class="command">
                <p class="command-text">{{ $round['direction'] }}</p>
            </div>
            @if ($game !== 'menulisefektif')
            <form class="question-list" id="question-list" method="POST" action="{{ url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/' . $taskId . '/finishes') }}" id="process" data-total="{{ count($questions) }}" data-task="{{ $taskId }}" data-check="{{ url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/check') }}" data-timer="{{ $timespan }}">
                @foreach($questions as $key => $question)
                <div class="question-item" data-index="{{ $key }}" data-number="{{ ++$key }}" data-repeatance="0" data-id="{{ $question['id'] }}">
                    <!-- Notification -->
                    <div class="notification @if($game === 'toeicwords') toeic-notification @endif">
                        <p class="notification-text notification-success">
                            <i class="kejar kejar-soal-benar"></i> Benar!
                        </p>
                        @if($game == 'obr')
                        <p class="notification-text notification-failed">
                            &times; Salah
                        </p>
                        @else
                        <p class="notification-text notification-failed">
                            &times; Seharusnya: <span class="text-dark d-inline seharusnya"></span>
                        </p>
                        @endif
                    </div>
                    <!-- Description For TOEIC Words Exam -->
                    @if ($game == 'toeicwords')
                    <div class="toeic-description">
                        <h2 class="toeic-description-text">
                            {{ $round['description'] }}
                        </h2>
                    </div>
                    @endif
                    <!-- Question -->
                    <div class="question @if($game == 'toeicwords') toeic-question @endif">
                        <h1 class="question-text">
                            @if($game == 'obr')
                                {{ '$'. $question['question'] . '$' }}
                            @else
                                {{ $question['question'] }}
                            @endif
                        </h1>
                    </div>
                    <!-- Answer Input -->
                    <div class="answer">
                        <input type="text" class="answer-input" name="answer[{{ $key }}]" data-status="false" autocomplete="off" @if($game==="obr") inputmode="tel" @endif>
                    </div>
                    <!-- Next Button -->
                    <div class="next-button">
                        <button class="btn btn-next btn-next-disabled" disabled>LANJUT <i class="kejar kejar-next"></i></button>
                    </div>
                </div>
                @endforeach
            </form>
            @else
                <form class="menulis-efektif question-list" id="question-list" method="POST" action="{{ url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/' . $taskId . '/finishes') }}" id="process" data-total="{{ count($questions) }}" data-task="{{ $taskId }}" data-check="{{ url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/check') }}" data-timer="{{ $timespan }}">
                    @foreach($questions as $key => $question)
                        <div class="question-item" data-index="{{ $key }}" data-number="{{ ++$key }}" data-repeatance="0" data-id="{{ $question['id'] }}">
                            <!-- Question -->
                            <div class="question">
                                <h1 class="question-text editor-display">
                                    {!! $question['question'] !!}
                                </h1>
                            </div>
                            <!-- Answer Input -->
                            <div class="answer">
                                <textarea class="answer-input" placeholder="Ketik jawaban di sini ..." data-status="false" autocomplete="off"></textarea>
                            </div>
                            <!-- Next Button -->
                            <div class="exam-button">
                                <div>
                                    <h2 class="answer-status d-none"></h2>
                                </div>
                                <div>
                                    <button class="btn btn-check" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>
                                </div>
                            </div>

                            <!-- Pebahasan -->
                            <div class="pembahasan">
                                <h5>Pembahasan</h5>
                                <div class="explanation-text editor-display"></div>
                                <div class="alternative-answers">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>
            @endif
        </div>
    </div>
</div>
@include('student.exams._exit_confirmation')
@endsection

@push('script')

@if ($game == 'menulisefektif')
<script src="{{ mix('/js/student/exam/menulis-efektif.js') }}"></script>
@else
<script src="{{ mix('/js/student/exam/script.js') }}"></script>
@endif

@if($game == 'obr')
    <script src="{{ mix('/js/check-for-tex.js') }}" defer></script>
@endif

@endpush
