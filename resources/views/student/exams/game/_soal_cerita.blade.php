@extends('layout.index')

@section('title', 'Permainan - ' . $round['title'])

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
            <!-- <div class="command">
                <p class="command-text">{{ $round['direction'] }}</p>
            </div> -->
            <form class="question-list" id="question-list" method="POST" action="{{ url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/' . $taskId . '/finishes') }}" id="process" data-total="{{ count($questions) }}" data-task="{{ $taskId }}" data-check="{{ url('student/games/' . $game . '/stages/' . $stageId . '/rounds/' . $roundId . '/check') }}" data-timer="{{ $timespan }}">
                @foreach($questions as $key => $question)
                    @if ($question['type'] === 'TFQMA')
                    <!-- include the question by the question' type -->
                    <!-- Type TFQMA/Benar Salah -->
                        @include('student.exams.quesiton_type._benar_salah')
                    @endif
                @endforeach

            </form>
        </div>
    </div>
</div>
@include('student.exams._exit_confirmation')
@endsection

@push('script')
<!-- Major Script -->
<script src="{{ mix('/js/student/exam/soal-cerita.js') }}"></script>
@endpush
