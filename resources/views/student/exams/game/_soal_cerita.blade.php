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
                    
                    @if ($question['type'] === 'YNQMA')
                    <!-- include the question by the question' type -->
                    <!-- Type YNQMA/Ya Tidak -->
                        @include('student.exams.question_type._ya_tidak')
                    @endif

                    @if ($question['type'] === 'MQIA')
                        <!-- Type MQIA/Isian Matematika -->
                        @include('student.exams.question_type._isian_matematika')
                    @endif

                    @if ($question['type'] === 'MCQSA')
                        <!-- Type MCQSA/Pilihan Ganda -->
                        @include('student.exams.question_type._pilihan_ganda')
                    @endif

                    @if ($question['type'] === 'SSQ')
                        <!-- SSQ / Mengurutkan -->
                        @include('student.exams.question_type._mengurutkan')
                    @endif 
                    
                    @if ($question['type'] === 'MQ')
                        <!-- MQ/Memasangkan -->
                        @include('student.exams.question_type._memasangkan')
                    @endif

                    @if ($question['type'] === 'CTQ')
                        <!-- Type CTQ/Melengkapi Tabel -->
                        @include('student.exams.question_type._melengkapi_tabel')
                    @endif

                    @if ($question['type'] === 'BDCQMA')
                        <!-- Type BDCQMA/Merinci -->
                        @include('student.exams.question_type._merinci')    
                    @endif

                    @if ($question['type'] === 'EQ')
                        <!-- Type EQ/Esai -->
                        @include('student.exams.question_type._esai')
                    @endif

                    @if ($question['type'] === 'QSAT')
                        <!-- Type CTQ/Melengkapi Tabel -->
                        @include('student.exams.question_type._isian_bahasa')
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
<script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
<script src="{{ mix('/js/student/exam/soal-cerita.js') }}"></script>
@endpush
