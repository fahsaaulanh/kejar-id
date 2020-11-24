<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="isian_matematika" data-repeat="false">
    <p class="_soal_cerita_direction">Jawablah dengan benar!</p>

    <div class="_isian_matematika_direction">{!! $question['question'] !!}</div>
    
    <div class="_isian_matematika_question editor-display">
        @for ($x = 0; $x < count($question['choices']['first']); $x++)
            @if ($question['choices']['first'][$x] !== null)
                <span class="_isian_matematika_question_text">{!! $question['choices']['first'][$x] !!}</span>
            @endif
            <input type="text" inputmode="tel" class="_isian_matematika_input" placeholder="..." value="" autocomplete="off" name="answers[]">
            @if ($question['choices']['last'][$x] !== null)
                <span class="_isian_matematika_question_text">{!! $question['choices']['last'][$x] !!}</span>
            @endif
        @endfor
    </div>
    
    
    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>


    <div class="_isian_matematika_session">
        <div class="_isian_matematika_right_answers editor-display">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_isian_matematika_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>
</div>
