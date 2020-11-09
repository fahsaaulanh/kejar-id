 <div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="pilihan_ganda" data-repeat="false">
    <p class="_pilihan_ganda_direction">Pilihlah jawaban yang benar!</p>

    <!-- Question -->
    <div class="_pilihan_ganda_question editor-display">
        {!! $question['question'] !!}
    </div>
    
    <!-- Answer Input -->
    <div class="_pilihan_ganda_answer">
        @foreach($question['choices'] as $key => $choice)
        <label class="_pilihan_ganda_radio_answer">{!! $choice !!}
            <input type="radio" name="answer" value="{{ $key }}">
            <i class="kejar kejar-{{ strtolower($key) }}-ellipse"></i>
        </label>
        @endforeach
    </div>
    
    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>

    <div class="_pilihan_ganda_session">
        <div class="_pilihan_ganda_right_answers">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_pilihan_ganda_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>

</div>
